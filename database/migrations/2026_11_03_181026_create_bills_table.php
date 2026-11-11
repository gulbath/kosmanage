<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('bill_number')->unique();
            $table->foreignId('occupancy_id')->constrained('occupancies')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->integer('period_month');
            $table->integer('period_year');
            $table->bigInteger('amount');
            $table->date('due_date');
            $table->enum('status', ['unpaid', 'pending', 'paid', 'overdue'])->default('unpaid');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['period_year', 'period_month']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};