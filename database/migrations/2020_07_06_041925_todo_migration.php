<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TodoMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo', function(Blueprint $table){
            // $table->bigIncrements('id')->autoIncrement();
            $table->id();
            $table->uuid('todo_id');
            $table->timestamps();
            $table->string('todo');
            $table->timestamp('completed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todo');
    }
}
