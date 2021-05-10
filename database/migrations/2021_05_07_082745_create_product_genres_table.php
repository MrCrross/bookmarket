<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_genres', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('CASCADE');
            $table->bigInteger('genre_id')->unsigned();
            $table->foreign('genre_id')
                ->references('id')
                ->on('genres')
                ->onDelete('CASCADE');
            $table->timestamps();
            $table->primary(['product_id', 'genre_id'], 'product_genres_product_id_genre_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_genres');
    }
}
