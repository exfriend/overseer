<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class OviCreateTasksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'laravel_tasks', function ( Blueprint $table )
        {
            $table->increments( 'id' );
            $table->string( 'title' );
            $table->boolean( 'is_running' );
            $table->string( 'description' );
            $table->datetime( 'last_run' );
            $table->string( 'class_name' );
            $table->timestamps();
        } );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop( 'laravel_tasks' );
    }
}
