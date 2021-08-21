<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAppsInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_apps_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo')->nullable();
            $table->string('appId')->nullable();
            $table->string('name')->nullable();
            $table->string('privacyPoliceUrl')->nullable();
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->longText('data')->nullable();
            $table->longText('reviews')->nullable();
            $table->string('released')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('tbl_apps_info');
    }
}
