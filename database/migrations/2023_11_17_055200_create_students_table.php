<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('id_no');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->enum('gender', ['male', 'female']);
            $table->string('mobile');
            $table->date('birthdate');
            $table->string('email')->unique();
            $table->string('course');
            $table->unsignedInteger('year');
            $table->string('section');
            $table->string('address')->nullable();
            $table->string('profile_picture')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('students');
    }
}
