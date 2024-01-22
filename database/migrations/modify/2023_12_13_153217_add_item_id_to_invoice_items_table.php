<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->after('project_id')->nullable();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropColumn('item_id');
        });
    }
};
