<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->text('body');
            //$table->string('image', 50); //the file will be renamed using UUID which is pretty enough length
            $table->string('image', 255); //the file will be renamed using UUID which is pretty enough length

            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id', 'fk_posts_1')
                ->references('id')
                ->on('authors')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('posts');
    }
}
