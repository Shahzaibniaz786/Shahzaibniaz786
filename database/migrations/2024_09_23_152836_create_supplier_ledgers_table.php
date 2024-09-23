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
        Schema::create('supplier_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->nullable();  
            $table->foreignId('purchase_id')->nullable();  
            $table->foreignId('product_id')->nullable();   
            $table->decimal('amount', 10, 2)->nullable();  
            $table->decimal('debit', 10, 2)->nullable();      
            $table->decimal('credit', 10, 2)->nullable();      
            $table->decimal('balance', 10, 2)->nullable();     
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_ledgers');
    }
};
