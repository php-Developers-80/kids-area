<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->enum('client_type', ['parent','son'])
                ->default('parent')
                ->nullable();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('customers')
                ->onDelete('cascade');

            $table->string('name')->nullable();
            $table->string('customer_work')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('website_link')->nullable();
            $table->string('logo')->nullable();
            $table->longText('notes')->nullable();


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
        Schema::dropIfExists('customers');
    }
}
