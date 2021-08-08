<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('customers')
                ->onDelete('cascade');

            $table->foreignId('ticket_id')
                ->nullable()
                ->constrained('tickets')
                ->onDelete('cascade');

            $table->double('original_cost')->default(0);

            $table->double('discount_rate')->default(0);
            $table->double('discount_value')->default(0);

            $table->double('total_cost')->default(0);

            $table->text('notes')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->enum('status',['new','still_going_on','finished','canceled'])
                ->default('new');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')
                ->references('id')->on('users')
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
        Schema::dropIfExists('orders');
    }
}
