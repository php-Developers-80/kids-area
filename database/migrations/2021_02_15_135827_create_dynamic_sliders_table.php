<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamic_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('en_title')->nullable();
            $table->string('ar_title')->nullable();
            $table->string('route_link')->nullable();
            $table->string('order_number')->nullable();
            $table->string('image')->nullable();
            $table->string('font_icon')->nullable();

            $table->string('permission_name')->nullable();

            $table->unsignedBigInteger('permission_id')->nullable();
            $table->foreign('permission_id')
                ->references('id')->on('permissions')
                ->onDelete('cascade');


            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')
                ->references('id')->on('dynamic_sliders')
                ->onDelete('cascade');

            $table->enum('with_notification',['yes','no'])
                ->default('no')
                ->nullable();


            $table->enum('is_shown',['shown','hidden'])
                ->default('shown')
                ->nullable();

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
        Schema::dropIfExists('dynamic_sliders');
    }
}
