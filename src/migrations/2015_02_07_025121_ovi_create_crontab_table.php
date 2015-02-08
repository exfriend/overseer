<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class OviCreateCrontabTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'crontab', function ( Blueprint $table )
        {
            $table->increments( 'id' );
            $table->integer( 'task_id' );
            $table->string( 'minute' );
            $table->string( 'hour' );
            $table->string( 'day_of_month' );
            $table->string( 'day_of_week' );
            $table->string( 'month' );
            $table->boolean( 'active' );
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
        Schema::drop( 'crontab' );
    }

}
