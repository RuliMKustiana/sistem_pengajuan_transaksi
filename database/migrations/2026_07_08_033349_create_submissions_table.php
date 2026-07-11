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
        // 1. Tabel utama submissions
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('submission_number', 50)->unique(); 
            $table->date('submission_date'); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); 
            $table->decimal('amount', 15, 2); 
            $table->text('description'); 
            $table->string('attachment')->nullable(); 
            $table->enum('status', [
                'Draft', 'Submitted', 'Waiting SPV Approval', 
                'Waiting Manager Approval', 'Waiting Director Approval', 
                'Waiting Finance', 'Paid', 'Rejected'
            ])->default('Draft'); 
            $table->timestamps();
        });

        // 2. Tabel approvals (mengacu ke submissions)
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); 
            $table->enum('status', ['Approved', 'Rejected']); 
            $table->text('notes')->nullable(); 
            $table->timestamps();
        });

        // 3. Tabel payments (mengacu ke submissions)
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); 
            $table->date('payment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
