<?php
/**
 * Created by PhpStorm.
 * User: thoth
 * Date: 2019-06-03
 * Time: 14:28
 */

namespace App\Services;


use App\Repositories\MembersRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTAuth;
use GuzzleHttp\Client;

class MembersServices
{
    private $membersRepository;

    protected $JWTAuth;

    public function __construct(
        MembersRepository $membersRepository,
        JWTAuth $JWTAuth)
    {
        $this->membersRepository = $membersRepository;
        $this->JWTAuth = $JWTAuth;
    }

    public function create($request)
    {
        try{

            $num = "1234567890";
            $account = 'TH'.substr(str_shuffle($num),4,4);
            $en = "abcdefghijklmnopqrstuvwxyz0123496789";
            $password = substr(str_shuffle($en),4,8);

            //dd($password);
            $result = $this->membersRepository->create([
                'mobile' => $request['mobile'],
                'active' => 1,
                'account' => $account,
                'password' => Hash::make($password),
            ]);
            return [
                'code'   => config('apiCode.success'),
                'result' => $result,
            ];
        }catch (\Exception $e){
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    public function apiGet($request)
    {
        $client = new Client();
        try {
            $res = $client->request(
                'POST',
                'http://balancepay.thoth-dev.com/api/member/login',
                ['form_params' => [
                    'account' => $request['account'],
                    'public_key' => 'a6ab9ff4451b68215d7f',
                    'hash' => md5($request['account'].'c23899e5-57ab-416d-9c7a-13bdb0e73682')
                ]
                ]);
            //json轉成array
            $result= json_decode($res->getBody());
           // dd($result);
            foreach ($result as $key => $value){
                if ($key =='result'){
                    return redirect('http://balancepay.thoth-dev.com/member/redirect?token='.$value);
            }}
            //$tok = json_decode($token->getBody());
//            return [
//                'code'   => config('apiCode.success'),
//                'result' => $token,
//            ];
        } catch (GuzzleException $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    public function editUser($id,$request)
    {
        $client = new Client();
        try{
            $req = $this->membersRepository->find($id);
//dd($request->input('password'));
            if ($request->input('password') != '') {
                $result = $this->membersRepository->editUser($id,[
                    'active' => $request['active'],
                    'password' => Hash::make($request['password']),
                ]);

                if ($request['active'] == 2) {
                    $client->request(
                        'POST',
                        'http://balancepay.thoth-dev.com/api/kick/user',
                        ['form_params' => [
                            'account' => $req['account'],
                            'public_key' => 'a6ab9ff4451b68215d7f',
                            'hash' => md5($req['account'].'c23899e5-57ab-416d-9c7a-13bdb0e73682')
                        ]
                        ]);
                }
                return [
                    'code'   => config('apiCode.success'),
                    'result' => $result,
                ];
            }else{
                $result = $this->membersRepository->editUser($id,[
                    'active' => $request['active']
                ]);
                return [
                    'code'   => config('apiCode.success'),
                    'result' => $result,
                ];
            }
        }catch (\Exception $e){
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    public function delete($id)
    {//dd($request);
        try{
            $client = new Client();
            $req = $this->membersRepository->find($id);
            $result = $this->membersRepository->delete($id);
            $client->request(
                'POST',
                'http://balancepay.thoth-dev.com/api/kick/user',
                ['form_params' => [
                    'account' => $req['account'],
                    'public_key' => 'a6ab9ff4451b68215d7f',
                    'hash' => md5($req['account'].'c23899e5-57ab-416d-9c7a-13bdb0e73682')
                ]
                ]);

            return [
                'code'   => config('apiCode.success'),
                'result' => $result,
            ];
        }catch (\Exception $e){
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }
}