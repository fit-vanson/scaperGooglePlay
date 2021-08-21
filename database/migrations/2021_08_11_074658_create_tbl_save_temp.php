<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSaveTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_save_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('appId')->nullable();
            $table->string('name')->nullable();
            $table->integer('installs')->nullable();
            $table->integer('numberVoters')->nullable();
            $table->integer('numberReviews')->nullable();
            $table->string('score')->nullable();
            $table->string('appVersion')->nullable();
            $table->string('released')->nullable();
            $table->string('updated')->nullable();
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
        Schema::dropIfExists('tbl_save_temp');
    }
}
