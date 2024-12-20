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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->boolean('is_superadmin')->default(0);
            $table->string('profile_image')->nullable();
            $table->string('status')->default('Enable');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('profile_image');
            $table->dropColumn('status');

            $table->dropColumn('phone');
            $table->dropColumn('address');

            $table->dropColumn('is_superadmin');

            $table->dropColumn('company_id');
        });
    }
};
