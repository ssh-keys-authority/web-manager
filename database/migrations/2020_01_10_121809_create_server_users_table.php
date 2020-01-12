<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'server_users',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->uuid('uuid');
                $table->string('name');
                $table->unsignedBigInteger('server_id');
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
        Schema::dropIfExists('server_users');
    }
}
