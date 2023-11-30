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
        Schema::create('lead_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address');
            $table->string('gender');
            $table->string('job_title');
            $table->string('image')->nullable();
            $table->boolean('is_primary_contact');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('lead_id', 'lead_contacts_lead_id_foreign')->references('id')->on('leads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_contacts', function (Blueprint $table) {
            $table->dropForeign('lead_contacts_lead_id_foreign');
            $table->dropIfExists('lead_contacts');
        });
    }
};
