<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_configs', function (Blueprint $table) {
            $table->increments('id')->comment('고유값');
            $table->string('board_id')->comment('게시판 영문ID')->index();
            $table->string('name')->comment('게시판 이름')->index();
            $table->unsignedTinyInteger('use_secret')->comment('비밀글 사용여부 [ 0 : 미사용, 1 : 사용, 2 : 모든 글 비밀글 ]')->default(1);
            $table->unsignedTinyInteger('use_notice')->comment('공지글 목록 출력 여부 [ 0 : 미사용, 1 : 첫페이지만 출력, 2 : 모든페이지 출력 ]')->default(0);
            $table->unsignedTinyInteger('use_editor')->comment('에디터 사용 여부 [ 0 : 미사용, 1 : 사용 ]')->default(1);
            $table->unsignedTinyInteger('use_comment')->comment('댓글 사용 여부 [ 0 : 미사용, 1 : 사용 ]')->default(0);
            $table->unsignedTinyInteger('use_comment_reply')->comment('대댓글 사용 여부 [ 0 : 미사용, 1 : 사용 ]')->default(0);
            $table->unsignedTinyInteger('comment_max_depth')->comment('대댓글 최대 깊이')->default(0);
            $table->string('permission_read')->comment('게시판 읽기 권한 설정')->nullable();
            $table->string('permission_write')->comment('게시판 쓰기 권한 설정')->nullable();
            $table->string('permission_comment')->comment('게시판 댓글 달기 권한 설정')->nullable();
            $table->string('permission_manage')->comment('게시판 관리 권한 설정')->nullable();
            $table->unsignedTinyInteger('use_vote')->comment('추천 사용 여부 [ 0 : 미사용, 1 : 사용 ]')->default(0);
            $table->unsignedTinyInteger('use_commnet_vote')->comment('댓글추천 사용 여부 [ 0 : 미사용, 1 : 사용 ]')->default(0);
            $table->unsignedInteger('upload_file_count')->comment('파일 업로드 개수 설정 [ 0 설정시 미사용 ]')->default(0);
            $table->unsignedInteger('upload_file_size')->comment('업로드 파일 최대 크기 설정(MB 단위)')->default(10);
            $table->unsignedInteger('write_time_limit')->comment('글 작성 제한시간 [ 단위 : 분 ]')->default(10);
            //$table->timestamps();
            $table->timestamp('created_at')->comment('등록일')->nullable();
            $table->timestamp('updated_at')->comment('수정일')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_configs');
    }
}
