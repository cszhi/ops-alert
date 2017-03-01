<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->default('')->comment('用户名');
            $table->string('weixin', 30)->default('')->unique()->comment('微信账号');
            $table->string('email', 60)->default('')->unique()->comment('邮箱账号');
            $table->string('comment')->default('')->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('a_users');
    }
}
