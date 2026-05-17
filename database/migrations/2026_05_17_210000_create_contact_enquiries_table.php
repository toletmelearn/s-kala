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
        Schema::create('contact_enquiries', function (Blueprint $table): void {
            $table->id();
            $table->string('enquiry_no')->nullable()->unique();
            $table->enum('type', ['general', 'csr_partner', 'volunteer', 'visit_request', 'collaboration', 'training_help', 'other'])->default('general');
            $table->string('name');
            $table->string('organization')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->longText('message')->nullable();
            $table->string('preferred_contact_method')->nullable();
            $table->enum('status', ['new', 'contacted', 'in_progress', 'closed', 'rejected'])->default('new');
            $table->longText('admin_notes')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_enquiries');
    }
};
