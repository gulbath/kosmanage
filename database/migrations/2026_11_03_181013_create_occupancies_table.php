<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('occupancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->bigInteger('agreed_price');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'finished'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['room_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('occupancies');
    }
};