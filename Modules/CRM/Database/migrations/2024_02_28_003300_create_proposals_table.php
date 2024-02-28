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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('client_id')->nullable();
            $table->foreignId('lead_id')->nullable();
            $table->foreignId('tax_type_id')->nullable();
            $table->text('note')->nullable();

            $table->foreign('client_id', 'proposals_client_id_foreign')->references('id')->on('clients')->onDelete('set NULL');
            $table->foreign('lead_id', 'proposals_lead_id_foreign')->references('id')->on('leads')->onDelete('set NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropForeign('proposals_client_id_foreign');
            $table->dropForeign('proposals_lead_id_foreign');
            $table->dropIfExists();
        });
    }
};
