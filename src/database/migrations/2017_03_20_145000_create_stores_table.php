<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->default('active');
            $table->string('type', 150);
            $table->string('name', 150);
            $table->string('zipcode');
            $table->string('address');
            $table->string('phone', 15)->nullable();
            $table->string('latitude', 150);
            $table->string('longitude', 150);
            $table->text('description');
            $table->string('city');
            $table->string('state');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('stores');
    }
}
