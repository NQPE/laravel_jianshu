<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path')->default('')->comment('文件存储路径');
            $table->string('filename')->default('')->comment('文件存储名字');
            $table->string('md5')->default('')->comment('文件MD5');
            $table->string('mimeType')->default('')->comment('文件类型');
            $table->string('ext')->default('')->comment('文件后缀');
            $table->string('driver')->default('')->comment('文件保存驱动');
            $table->integer('size')->default(0)->comment('文件大小');
            $table->tinyInteger('status')->default(1)->comment('状态码');
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
        Schema::dropIfExists('files');
    }
}
