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
            $table->string('name');
            $table->unsignedBigInteger('cate_id');
            $table->string('image');
            $table->json('size')->nullable();
            $table->json('color')->nullable();
            $table->integer('price');
            $table->text('description');
            $table->integer('percent_discount');
            $table->integer('quantity_sold');
            $table->unsignedBigInteger('favorite_count')->default(0);
            $table->timestamps();

            $table->foreign('cate_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
