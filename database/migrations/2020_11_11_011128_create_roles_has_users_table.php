<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesHasUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_has_users', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('users_id')->unsigned();
             $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
             $table->unsignedBigInteger('roles_id')->unsigned();
             $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');
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
        Schema::dropIfExists('roles_has_users');
    }
}
