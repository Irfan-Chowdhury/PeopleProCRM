<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id');
            $table->foreignId('employee_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->integer('points');
            $table->string('collaborator_employee_ids')->nullable();
            $table->string('status');
            $table->string('priority')->nullable();
            $table->string('labels')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('file')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('lead_id', 'lead_tasks_lead_id_foreign')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('employee_id', 'lead_tasks_employee_id_foreign')->references('id')->on('employees')->onDelete('set NULL');
        });
    }


    public function down(): void
    {
        Schema::table('lead_tasks', function (Blueprint $table) {
            $table->dropForeign('lead_tasks_lead_id_foreign');
            $table->dropForeign('lead_tasks_employee_id_foreign');
            $table->dropIfExists('lead_tasks');
        });
    }
};
