<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->increments('id')->comment('아이디값');
            $table->unsignedInteger('board_id')->comment('게시판 아이디')->index();
            $table->unsignedInteger('user_id')->comment('작성자 고유번호')->unsigned()->index();
            $table->unsignedTinyInteger('is_notice')->comment('공지사항 여부 [ 0 : 공지 미적용, 1 : 공지적용 ]')->default(0);
            $table->unsignedTinyInteger('is_secret')->comment('비밀글 사용여부 [ 0 : 비밀글 미적용, 1 : 비밀글 적용 ]')->default(0);
            $table->unsignedTinyInteger('is_editor')->comment('에디터 사용하여 작성 여부 [ 0 : 미사용, 1 : 사용 ]')->default(0);
            $table->string('name', 50)->comment('작성자 이름')->nullable();
            $table->string('password')->comment('글 비밀번호')->nullable();
            $table->string('title')->comment('제목');
            $table->longText('content')->comment('내용');
            $table->unsignedInteger('view_count')->comment('조회수')->default(0);
            $table->string('ip', 30)->comment('작성자 IP')->nullable();

            //$table->timestamps();
            $table->timestamp('created_at')->comment('등록일')->nullable();
            $table->timestamp('updated_at')->comment('수정일')->nullable();

            $table->foreign('board_id')->references('id')->on('board_configs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
