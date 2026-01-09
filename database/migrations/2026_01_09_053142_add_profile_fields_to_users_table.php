<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // role
            $table->string('role')->default('customer')->after('password');
            // profile fields
            $table->string('phone')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('dob')->nullable();
            $table->string('marital_status')->nullable();
            $table->text('address')->nullable();
            $table->string('profile_image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone',
                'gender',
                'dob',
                'marital_status',
                'address',
                'profile_image',
            ]);
        });
    }
};
