<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaConversionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_conversion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->references('id')->on('media')->onDelete('cascade');
            $table->string('name');
            $table->string('file_name');
            $table->string('path');
            $table->string('url');
            $table->string('width');
            $table->string('height');
            $table->string('padding');
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
        Schema::dropIfExists('media_conversion');
    }
}
