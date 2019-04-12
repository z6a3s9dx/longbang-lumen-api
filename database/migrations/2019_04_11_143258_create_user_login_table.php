<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_login', function (Blueprint $table) {
            $table->increments('id')->comment('PK');
            $table->smallInteger('user_id')->unsigned()->comment('使用者ID');

            $table->foreign('user_id', 'user_login_ibfk_1')
                ->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('user_account', 12)->default('')->comment('使用者帳號');
            $table->string('user_password', 10)->default('')->comment('使用者密碼');
            $table->string('login_ip',46)->comment('登入IP(強制登出，則塞入空值)');
            $table->unsignedTinyInteger('status')->default(1)->comment('狀態(1:登入成功、2:正常登出、3:強制登出)');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `user_login` COMMENT '使用者登入日誌'");
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_login');
        /*Schema::table('user_login', function (Blueprint $table) {
            //
        });*/
    }
}
