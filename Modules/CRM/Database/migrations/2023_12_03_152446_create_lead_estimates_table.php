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
        Schema::create('lead_estimates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id');
            $table->foreignId('tax_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('lead_id', 'lead_estimates_lead_id_foreign')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('tax_id', 'lead_estimates_tax_id_foreign')->references('id')->on('taxes')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_estimates', function (Blueprint $table) {
            $table->dropForeign('lead_estimates_lead_id_foreign');
            $table->dropForeign('lead_estimates_tax_id_foreign');
            $table->dropIfExists('lead_estimates');
        });
    }
};
