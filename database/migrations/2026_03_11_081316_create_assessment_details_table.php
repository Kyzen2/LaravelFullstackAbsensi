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
    Schema::create('assessment_details', function (Blueprint $table) {
        $table->id();
        // FK ke tabel assessments
        $table->foreignId('assessment_id')->constrained('assessments')->onDelete('cascade');
        // FK ke tabel assessment_categories
        $table->foreignId('category_id')->constrained('assessment_categories')->onDelete('cascade');
        
        $table->decimal('score', 5, 2); // Pake decimal biar bisa nilai kyk 4.5
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_details');
    }
};
