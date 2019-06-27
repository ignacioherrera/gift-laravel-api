<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventNameField extends Migration
{
    public function up()
    {
        
        Schema::table('events', function (Blueprint $table) {
            $table->string('name');
            $table->date('event_date');
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['name', 'event_date']);
        });
    }
}
