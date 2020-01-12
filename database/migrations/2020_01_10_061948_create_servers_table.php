<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'servers',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->uuid('uuid');
                $table->string('name');
                $table->unsignedBigInteger('operatingsystem_id');
                $table->dateTime('last_sync')->nullable();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers');
    }
}
