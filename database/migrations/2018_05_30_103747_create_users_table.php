<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->smallIncrements('id')->comment('PK');
            $table->string('account', 12)->unique()->comment('帳號');
            $table->string('password', 60)->default('')->comment('密碼');
            $table->string('name', 10)->default('')->comment('名稱');
            $table->longText('token')->comment('登入 Token');
            $table->unsignedTinyInteger('active')->default(1)->comment('狀態(1:啟用,2:停用)');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `users` COMMENT '管理人員資料'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
