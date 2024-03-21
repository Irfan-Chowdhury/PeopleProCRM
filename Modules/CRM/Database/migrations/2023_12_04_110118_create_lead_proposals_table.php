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
        Schema::create('lead_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id');
            $table->unsignedBigInteger('tax_type_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('lead_id', 'lead_proposals_lead_id_foreign')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('tax_type_id', 'lead_proposals_tax_type_id_foreign')->references('id')->on('tax_types')->onDelete('set NULL');
        });
    }

    public function down(): void
    {
        Schema::table('lead_proposals', function (Blueprint $table) {
            $table->dropForeign('lead_proposals_lead_id_foreign');
            $table->dropForeign('lead_proposals_tax_type_id_foreign');
            $table->dropIfExists();
        });
    }
};
