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
        Schema::create('lead_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id');
            $table->string('file_title');
            $table->string('file_attachment');
            $table->text('file_description');
            $table->foreign('lead_id', 'lead_files_lead_id_foreign')->references('id')->on('leads')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::table('lead_files', function (Blueprint $table) {
            $table->dropForeign('lead_files_lead_id_foreign');
            $table->dropIfExists('lead_files');
        });
    }
};
