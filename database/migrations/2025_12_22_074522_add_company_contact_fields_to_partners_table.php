<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            // Add company-level contact fields
            $table->string('company_email')->nullable()->after('company_name');
            $table->string('company_phone')->nullable()->after('company_email');
            
            // Add contact person title/position
            $table->string('contact_person_title')->nullable()->after('contact_person');
        });

        // Copy existing contact_email to company_email where contact_email exists
        DB::statement('UPDATE partners SET company_email = contact_email WHERE contact_email IS NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn(['company_email', 'company_phone', 'contact_person_title']);
        });
    }
};
