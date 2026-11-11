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
    Schema::create('tenants', function (Blueprint $table) {
        $table->id();
        // Jika terhubung ke akun user (opsional)
        $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); 
        $table->string('name');
        $table->string('phone');
        $table->string('emergency_contact')->nullable();
        $table->string('identity_card')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant');
    }
};
