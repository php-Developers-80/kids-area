<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->string('user_name')->nullable()->comment('اسم المستخدم');
            $table->string('password')->nullable();


            $table->string('logo')->nullable();
            $table->string('ip_address')->nullable();

            $table->enum('access_permission',['inside_only','outside'])
                ->default('inside_only')
                ->nullable();

            $table->enum('user_type',['admin','cashier'])
                ->default('admin')
                ->nullable();

            $table->enum('is_block',['blocked','not_blocked'])
                ->default('not_blocked')
                ->nullable();

            $table->enum('is_login',['connected','not_connected'])
                ->default('not_connected')
                ->nullable();

            $table->integer('logout_time')->nullable();

            $table->string('forget_password_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
