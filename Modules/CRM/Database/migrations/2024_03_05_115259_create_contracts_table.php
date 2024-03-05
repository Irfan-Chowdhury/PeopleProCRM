<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable();
            $table->foreignId('lead_id')->nullable();
            $table->foreignId('project_id');
            $table->foreignId('tax_type_id')->nullable();
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('project_id', 'contracts_project_id_foreign')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('client_id', 'contracts_client_id_foreign')->references('id')->on('clients')->onDelete('set NULL');
            $table->foreign('lead_id', 'contracts_lead_id_foreign')->references('id')->on('leads')->onDelete('set NULL');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign('contracts_project_id_foreign');
            $table->dropForeign('contracts_client_id_foreign');
            $table->dropForeign('contracts_lead_id_foreign');
            $table->dropIfExists();
        });
    }
};
