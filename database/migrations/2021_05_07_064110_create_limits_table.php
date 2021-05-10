<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Limit;

class CreateLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('limits', function (Blueprint $table) {
            $table->id();
            $table->string('name',3)->unique();
            $table->timestamps();
        });

        $limits=[
          '0+',
          '3+',
          '6+',
          '10+',
          '12+',
          '16+',
          '18+'
        ];
        foreach ($limits as $limit){
            Limit::create([
                'name'=>$limit
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('limits');
    }
}
