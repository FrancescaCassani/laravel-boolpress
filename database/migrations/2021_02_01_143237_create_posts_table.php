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
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('where');
            $table->text('body');
            $table->string('slug');
            $table->timestamps();

            //Relazione MANY TO ONE: POST - USER  NB: non segnalo il cascade in quanto decido di tenere i post nonostante un utente si possa cancellare
            $table->foreign('user_id')   //FK
                  ->references('id')     //A quale colonna deve puntare la FK
                  ->on('users');         // Di USERS
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
