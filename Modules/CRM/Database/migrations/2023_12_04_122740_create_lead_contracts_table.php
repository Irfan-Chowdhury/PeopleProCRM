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
        Schema::create('lead_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id');
            $table->foreignId('project_id');
            $table->foreignId('tax_type_id');
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lead_id', 'lead_contracts_lead_id_foreign')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('project_id', 'lead_contracts_project_id_foreign')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('tax_type_id', 'lead_contracts_tax_type_id_foreign')->references('id')->on('tax_types')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::table('lead_contracts', function (Blueprint $table) {
            $table->dropForeign('lead_contracts_lead_id_foreign');
            $table->dropForeign('lead_contracts_project_id_foreign');
            $table->dropForeign('lead_contracts_tax_type_id_foreign');
            $table->dropIfExists();
        });
    }
};
