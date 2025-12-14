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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number')->unique();
            
            // Foreign keys
            $table->foreignId('partner_id')->constrained()->onDelete('cascade');
            $table->foreignId('site_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->foreignId('tenure_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('shift_id')->nullable(); // Will add FK when shifts table exists
            
            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique()->nullable();
            $table->string('phone');
            $table->date('date_of_birth');
            $table->string('nationality');
            $table->string('national_id_number')->unique();
            $table->string('nssf_number')->nullable();
            $table->string('tin_number')->nullable();
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed']);
            
            // Next of Kin
            $table->string('next_of_kin_name');
            $table->string('next_of_kin_relationship');
            $table->string('next_of_kin_phone');
            $table->text('next_of_kin_address');
            
            // Address
            $table->text('address');
            $table->string('district');
            $table->string('area_lc1');
            
            // Banking
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            
            // Compensation
            $table->decimal('daily_wage', 10, 2);
            $table->decimal('management_fee', 10, 2)->nullable();
            
            // Status
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
