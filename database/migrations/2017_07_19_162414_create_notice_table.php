<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //通知表
        Schema::create('notices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->comment('通知标题');
            $table->text('content')->comment('通知内容');
            $table->timestamps();
            $table->softDeletes();
        });
        //用户系统通知关系表
        Schema::create('user_notice', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户ID');
            $table->string('notice_id')->default(0)->comment('通知ID');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notices');
        Schema::dropIfExists('user_notice');
    }
}
