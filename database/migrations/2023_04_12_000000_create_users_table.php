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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->bigInteger('department_id')->unsigned();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['root', 'admin_po', 'admin_approval', 'admin_mrv']);
            $table->boolean('is_active');
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
