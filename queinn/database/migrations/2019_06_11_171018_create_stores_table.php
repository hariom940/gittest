<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->string('image');
            $table->string('type')->nullable();
            $table->string('url');
            $table->float('rating')->nullable();
            $table->boolean('Store_reviewed')->default('2','1=>Yes, 2=>No');
            $table->string('page_title');
            $table->string('page_keyword');
            $table->string('page_description');
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
        Schema::dropIfExists('stores');
    }
}
