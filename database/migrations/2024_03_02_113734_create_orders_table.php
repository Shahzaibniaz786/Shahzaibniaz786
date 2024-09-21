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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('marka_id');
            $table->integer('product_type');
            $table->float('purchase_qty', 15);
            $table->float('purchase_rate', 15);
            $table->float('total_purchase', 15);
            $table->integer('driver_id');
            $table->float('carriage_amount', 15);
            $table->float('total_carriage', 15);
            $table->float('grand_purchase_amount', 15);
            $table->integer('supplier_id');
            $table->integer('customer_id');
            $table->float('sale_rate', 15);
            $table->float('total_sale_amount', 15);
            $table->float('profit', 15);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
