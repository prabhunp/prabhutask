<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->index()->nullable();
            $table->string('last_name')->index()->nullable();
            $table->string('birthday')->index()->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('profile_image')->nullable();            
            $table->string('country')->index()->nullable(); 
            $table->string('team_name')->index()->nullable(); 
            $table->string('position')->index()->nullable();
            $table->string('college')->index()->nullable();
            $table->string('member')->index()->nullable();  
            $table->string('debut')->index()->nullable();
            $table->softDeletes();          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users_details');
    }
}
