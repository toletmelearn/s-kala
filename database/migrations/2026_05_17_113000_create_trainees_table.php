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
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            $table->string('registration_no')->unique()->nullable();
            $table->string('name');
            $table->string('guardian_name')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('phone');
            $table->string('alternate_phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('preferred_program_id')->nullable()->constrained('training_programs')->nullOnDelete();
            $table->string('education_level')->nullable();
            $table->string('occupation')->nullable();
            $table->string('previous_skill_experience')->nullable();
            $table->longText('reason_for_joining')->nullable();
            $table->enum('status', ['pending', 'contacted', 'enrolled', 'completed', 'rejected'])->default('pending');
            $table->string('source')->nullable();
            $table->longText('notes')->nullable();
            $table->string('photo')->nullable();
            $table->string('id_proof')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
};
