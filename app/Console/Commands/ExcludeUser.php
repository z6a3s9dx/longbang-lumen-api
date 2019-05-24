<?php

namespace App\Console\Commands;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Console\Command;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Manager;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\UserLoginRepository;

class ExcludeUser extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Exclude:User';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '踢除使用者，強制登出';

    private $userLoginRepository;
    private $userRepository;
    protected $JWTAuth;


    /**
     * Create a new command instance.
     *
     * @param UserLoginRepository $userLoginRepository
     * @param UserRepository $userRepository
     * @param JWTAuth $JWTAuth
     */
    public function __construct(
        UserLoginRepository $userLoginRepository,
        UserRepository $userRepository,
        JWTAuth $JWTAuth
    ){
        parent::__construct();
        $this->userLoginRepository = $userLoginRepository;
        $this->userRepository = $userRepository;
        $this->JWTAuth = $JWTAuth;
    }


    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $oldToken = $this->userRepository->oldToken();
        foreach ($oldToken as $key => $value){
           // dd($value->token);
            if ($value->token != null){
                $this->JWTAuth->setToken($value->token)->invalidate();

                $this->userLoginRepository->create([
                    'user_id' =>$value->id,
                    'user_account' =>$value->account,
                    'user_name' =>$value->name,
                    'login_ip' => '',
                    'status' => 3,
                ]);

                $this->userRepository->update($value->id,['token'=>null]);
            }
        }


    }
}
