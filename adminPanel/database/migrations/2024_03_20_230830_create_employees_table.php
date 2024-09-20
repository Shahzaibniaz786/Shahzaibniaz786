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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('opening_balance', 15)->default(0);
            $table->float('balance', 15)->default(0);
            $table->float('opening_advance_balance', 15)->default(0);
            $table->float('advance_balance', 15)->default(0);
            $table->float('basic_salary', 15);
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('address')->nullable();
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
