<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            // users 테이블에 대한 참조키
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            // roles 테이블에 대한 참조키
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');

            // user_id와 role_id 컬럼은 유일해야 함
            $table->unique(['user_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
