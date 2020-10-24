<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',256);
            $table->string('subtitle',100)->nullable();
            $table->string('slug',100);
            $table->string('language',100);
            $table->text('body');
            $table->boolean('status')->default(0);
            $table->integer('admin_id')->unsigned();
            $table->text('image');
            $table->integer('view_count')->default(0);
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
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
        Schema::dropIfExists('posts');
    }
}
