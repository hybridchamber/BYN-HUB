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
        Schema::create('demographics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('youth_profile_id');
            $table->string('civil_status')->nullable();
            $table->string('youth_age_group')->nullable();
            $table->string('educational_background')->nullable();
            $table->string('youth_classification')->nullable();
            $table->string('specific_needs_detail')->nullable();
            $table->string('work_status')->nullable();
            $table->string('registered_sk_voter')->nullable();
            $table->string('registered_national_voter')->nullable();
            $table->string('sk_assembly')->nullable();
            $table->string('sk_assembly_times_attended')->nullable();
            $table->string('sk_assembly_not_attended')->nullable();
            $table->string('vote_last_sk_election')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demographics');
    }
};
