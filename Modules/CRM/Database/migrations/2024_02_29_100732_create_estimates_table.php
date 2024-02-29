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
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('client_id')->nullable();
            $table->foreignId('tax_type_id')->nullable();
            $table->text('note')->nullable();

            $table->foreign('client_id', 'estimates_client_id_foreign')->references('id')->on('clients')->onDelete('set NULL');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::table('estimates', function (Blueprint $table) {
            $table->dropForeign('estimates_client_id_foreign');
            $table->dropIfExists();
        });
    }
};
