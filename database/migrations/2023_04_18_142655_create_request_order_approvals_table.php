<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('request_order_approvals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('request_order_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('level');
            $table->enum('status', ['pending', 'approved']);
            $table->date('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('request_order_id')->references('id')->on('request_orders')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_order_approvals');
    }
};
