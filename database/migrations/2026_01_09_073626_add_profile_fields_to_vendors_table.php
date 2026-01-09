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
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('phone', 10)->nullable()->after('email');
            $table->enum('gender', ['male','female'])->nullable();
            $table->date('dob')->nullable();
            $table->text('address')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('cover_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'gender',
                'dob',
                'address',
                'profile_image',
                'cover_image',
            ]);
        });
    }
};
