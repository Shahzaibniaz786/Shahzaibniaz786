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
        Schema::create('product_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable();       // Product ID (nullable)
            $table->foreignId('sale_id')->nullable();          // Sale ID (nullable)
            $table->foreignId('purchase_id')->nullable();      // Purchase ID (nullable)
            $table->foreignId('supplier_id')->nullable();      // Supplier ID (nullable)
            $table->integer('sale_stock')->nullable();                  // Sale stock (nullable)
            $table->integer('purchase_stock')->nullable();              // Purchase stock (nullable)
            $table->integer('balance')->nullable();                     // Balance (nullable)
            $table->timestamps();                                       // Timestamps (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_ledgers');
    }
};
