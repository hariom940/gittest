<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('description');
            $table->string('coupon_code')->nullable();
            $table->string('value');
            $table->integer('amount_type')->default('1', '1=>Fixed', '2=>Percentage');
            $table->dateTime('valid_till');
            $table->string('coupon_types');
            $table->string('link_to_go');
            $table->string('store_id');
            $table->integer('total_views')->nullable();
            $table->integer('views_today')->nullable();
            $table->integer('clicks')->nullable();
            $table->boolean('related')->default('2','1=>Yes, 2=>No' );
            $table->boolean('status')->default('1','1=>Enable, 2=>Disable');
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
        //
        Schema::dropIfExists('coupons');
    }
}
