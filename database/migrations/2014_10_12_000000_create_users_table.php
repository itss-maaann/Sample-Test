<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment = 'Name of user';
            $table->string('phone')->comment = 'Mobile number of user'; //Data-type is string because we don't have to perform any operations on this numeric number, otherwise i would have assigned Data-type integer
            $table->string('email')->comment = 'Email of user';
            $table->string('photo')->comment = 'Image of user';
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment = 'Password of user';
            $table->rememberToken();
            $table->softDeletes(); //Column for deleted_at (Soft Delete trait imported if User Model
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
        Schema::dropIfExists('users');
    }
}
