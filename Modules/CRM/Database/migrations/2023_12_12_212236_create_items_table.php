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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_category_id');
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->string('unit_type');
            // $table->decimal('rate');
            $table->boolean('is_client_visible');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('item_category_id', 'item_categories_item_category_id_foreign')->references('id')->on('item_categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('item_categories_item_category_id_foreign');
            $table->dropIfExists();
        });
    }
};
