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
        Schema::create('certificates', function (Blueprint $table): void {
            $table->id();
            $table->string('certificate_no')->unique();
            $table->foreignId('trainee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('training_program_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->date('issue_date');
            $table->date('completion_date')->nullable();
            $table->string('verification_code')->unique();
            $table->enum('status', ['draft', 'issued', 'revoked'])->default('draft');
            $table->text('remarks')->nullable();
            $table->string('issued_by')->nullable();
            $table->string('qr_path')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
