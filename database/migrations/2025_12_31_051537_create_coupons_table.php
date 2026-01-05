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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique(); // SAVE10, FLAT100
            $table->enum('type', ['percentage', 'flat']);
            $table->decimal('value', 10, 2);

            $table->decimal('min_order_amount', 10, 2)->nullable();

            $table->date('start_date');
            $table->date('end_date');

            $table->integer('usage_limit')->nullable(); // global limit
            $table->integer('used_count')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
