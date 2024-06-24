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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('categoryID')->nullable();
            $table->string('name')->nullable();
            $table->integer('article')->nullable();
            $table->string('image')->nullable();
            $table->string('galary')->nullable();
            $table->string('desc')->nullable();
            $table->integer('price')->nullable();
            $table->integer('newprice')->nullable();
            $table->integer('badgeID')->nullable();
            $table->integer('priority')->nullable();
            $table->integer('active')->nullable();
            $table->integer('views')->nullable();
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
        Schema::dropIfExists('products');
    }
};
