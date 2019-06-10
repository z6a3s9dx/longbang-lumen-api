<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('mobile', 10)->unique()->comment('會員手機');
            $table->string('account', 20)->unique()->comment('會員帳號');
            $table->string('password', 60)->default('')->comment('會員密碼');
            $table->unsignedTinyInteger('active')->default(1)->comment('狀態(1:啟用,2:停用)');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `Members` COMMENT '開立會員資料'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
