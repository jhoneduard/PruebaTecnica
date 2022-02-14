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
        Schema::create('role_type', function (Blueprint $table) {
            $table->id();
            $table->string('name',35);
            $table->string('name_screen',35);
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('nombre');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('id_role');
            $table->bigInteger('user_status');
            $table->primary('id');
            $table->foreign('id_role')
            ->references('id')
            ->on('role_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_type');
        Schema::dropIfExists('users');
    }
}
