<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Status;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name',25);
            $table->timestamps();

        });

        $statuses=[
            'Заказ обрабатывается',
            'Заказ готов',
            'Заказ отправлен',
            'Заказ ожидает',
            'Заказ получен'
        ];

        foreach ($statuses as $status){
            Status::create([
                'name'=>$status
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
        Schema::dropIfExists('statuses');
    }
}
