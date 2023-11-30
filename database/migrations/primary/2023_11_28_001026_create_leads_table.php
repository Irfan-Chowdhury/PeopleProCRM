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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('employee_id')->nullable();
            $table->string('status');
            $table->foreignId('country_id');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('address');
            $table->string('phone');
            $table->string('website')->nullable();
            $table->integer('vat_number');
            $table->integer('gst_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('company_id', 'leads_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('employee_id', 'leads_employee_id_foreign')->references('id')->on('employees')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign('leads_company_id_foreign');
            $table->dropForeign('leads_employee_id_foreign');
            $table->dropIfExists('leads');
        });
    }
};
