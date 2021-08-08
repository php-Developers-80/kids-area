<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('son_id')
                ->nullable()
                ->constrained('customers')
                ->onDelete('cascade');

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->onDelete('cascade');

            $table->foreignId('ticket_id')
                ->nullable()
                ->constrained('tickets')
                ->onDelete('cascade');




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
        Schema::dropIfExists('order_details');
    }
}
