<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('before')->default(0);
            $table->integer('after')->default(0);
            $table->enum('type', ['add', 'remove'])->default('add');
            $table->enum('origin', ['api', 'site'])->default('api');
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
        Schema::dropIfExists('stocks_logs');
    }
}
