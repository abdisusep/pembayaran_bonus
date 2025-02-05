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
        Schema::create('buruh', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bonus_id')->constrained('bonus')->onDelete('cascade');
            $table->string('name');
            $table->decimal('percentage', 5, 2);
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buruh');
    }
};
