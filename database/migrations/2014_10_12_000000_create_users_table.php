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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->index();
            $table->string('username')->unique()->index();
            $table->string('phone')->nullable();
            $table->string('ref')->unique()->index();
            $table->tinyInteger('gender')->default(0);
            $table->integer('city_id')->nullable();
            $table->longText('address')->nullable();
            $table->string('password');
            $table->boolean('admin')->default(false);
            $table->integer('account')->default(1);
            $table->boolean('active')->default(false);
            $table->boolean('suspend')->default(false);
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_logout_at')->nullable();
            $table->text('last_login_ip')->nullable();
            $table->text('register_ip')->nullable();
            $table->text('image')->nullable();
            $table->boolean('is_root')->default(false);
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
};
