<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barters', function (Blueprint $table) {
            $table->id();
            
            $table->date('date');
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedSmallInteger('transmitter_user_id');
            $table->unsignedSmallInteger('receptor_user_id')->nullable();
            $table->foreign('transmitter_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('receptor_user_id')->references('id')->on('users')->cascadeOnDelete();

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
        Schema::dropIfExists('barters');
    }
};
