<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->string('ISBN',17)->unique();
            $table->string('name')->unique();
            $table->integer('pages')->unsigned();
            $table->integer('price')->unsigned();
            $table->string('image')->unique();
            $table->year('year_release');
            $table->text('description');
            $table->bigInteger('limit_id')->unsigned();
            $table->foreign('limit_id')
                ->references('id')
                ->on('limits')
                ->onDelete('CASCADE');
            $table->bigInteger('publisher_id')->unsigned();
            $table->foreign('publisher_id')
                ->references('id')
                ->on('publishers')
                ->onDelete('CASCADE');
            $table->bigInteger('author_id')->unsigned();
            $table->foreign('author_id')
                ->references('id')
                ->on('authors')
                ->onDelete('CASCADE');
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
}
