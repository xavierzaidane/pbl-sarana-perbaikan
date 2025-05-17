<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatefacilityManagementTables extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_ID');
            $table->string('name', 50);
            $table->char('username', 100)->unique();
            $table->char('password', 100);
            $table->string('email', 200)->nullable();
            $table->enum('role', ['Admin', 'Student', 'Lecturer', 'Staff', 'Technician']);
            $table->string('profile_picture', 200)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('priority_assignment', function (Blueprint $table) {
            $table->id('priority_Assignment_ID');
            $table->boolean('Criteria_name_here');
            $table->enum('risk_Level', ['High risk', 'Medium risk', 'Low risk']);
        });

        Schema::create('report', function (Blueprint $table) {
            $table->id('report_ID');
            $table->unsignedBigInteger('user_ID');
            $table->unsignedBigInteger('priority_Assignment')->nullable();
            $table->string('facility_name', 50);
            $table->string('location', 200)->nullable();
            $table->string('description', 200)->nullable();
            $table->enum('category', ['Electronic', 'Table', 'Chair', 'Desk', 'Computer', 'Miscellaneous']);
            $table->string('picture_proof', 200)->nullable();
            $table->enum('status', ['Declined', 'Pending', 'In_progress', 'Solved'])->default('Pending');
            $table->timestamps();

            $table->foreign('user_ID')->references('user_ID')->on('users');
            $table->foreign('priority_Assignment')->references('priority_Assignment_ID')->on('priority_assignment');
        });

        Schema::create('repairs', function (Blueprint $table) {
            $table->id('repair_ID');
            $table->unsignedBigInteger('facility_report_id');
            $table->unsignedBigInteger('technician_id');
            $table->unsignedBigInteger('priority_Assignment')->nullable();
            $table->enum('repair_status', ['Not_started', 'In_progress', 'Completed'])->default('Not_started');
            $table->string('notes', 200)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('facility_report_id')->references('report_ID')->on('report');
            $table->foreign('technician_id')->references('user_ID')->on('users');
            $table->foreign('priority_Assignment')->references('priority_Assignment_ID')->on('priority_assignment');
        });

        Schema::create('building', function (Blueprint $table) {
            $table->id('building_ID');
            $table->string('name', 50);
            $table->string('location', 50)->nullable();
            $table->enum('status', ['Good', 'Fine', 'Damaged'])->default('Good');
        });

        Schema::create('facility', function (Blueprint $table) {
            $table->id('facility_ID');
            $table->string('name', 50);
            $table->enum('type', ['Electronic', 'Table', 'Chair', 'Desk', 'Computer', 'Miscellaneous']);
            $table->unsignedBigInteger('building_ID');
            $table->enum('status', ['Good', 'Fine', 'Damaged'])->default('Good');

            $table->foreign('building_ID')->references('building_ID')->on('building');
        });

        Schema::create('feedback', function (Blueprint $table) {
            $table->id('feedback_ID');
            $table->unsignedBigInteger('repairs_ID');
            $table->unsignedBigInteger('submitted_by');
            $table->string('feedback_content', 500)->nullable();
            $table->integer('rate');
            $table->foreign('repairs_ID')->references('repair_ID')->on('repairs');
            $table->foreign('submitted_by')->references('user_ID')->on('users');
        });

        Schema::create('FAQ', function (Blueprint $table) {
            $table->id('faq_ID');
            $table->string('question', 200);
            $table->string('answer', 200);
        });

        Schema::create('statistic_report', function (Blueprint $table) {
            $table->id('stat_ID');
            $table->enum('report_type', ['Monthly', 'Annual']);
            $table->text('content')->nullable();
        });

        Schema::create('damage_report', function (Blueprint $table) {
            $table->id('damage_report_ID');
            $table->unsignedBigInteger('facility_ID');
            $table->integer('total_report')->default(0);
            $table->string('frequent_damaged_facility', 200)->nullable();
            $table->string('frequent_total_damage', 50)->nullable();

            $table->foreign('facility_ID')->references('facility_ID')->on('facility');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('damage_report');
        Schema::dropIfExists('statistic_report');
        Schema::dropIfExists('FAQ');
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('facility');
        Schema::dropIfExists('building');
        Schema::dropIfExists('repairs');
        Schema::dropIfExists('report');
        Schema::dropIfExists('priority_assignment');
        Schema::dropIfExists('users');
    }
}
