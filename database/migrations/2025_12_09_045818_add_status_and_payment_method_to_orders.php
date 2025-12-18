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
        Schema::table('orders', function (Blueprint $table) {
    
            // COD / Stripe
            $table->string('payment_method')->default('cod')->after('total');
    
            // Order status (admin updates)
            $table->string('status')
                ->default('processing')   // other values: confirmed, shipped, delivered, cancelled
                ->after('payment_status');
        });
    }




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'status']);
        });
    }
};
