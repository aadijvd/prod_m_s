<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            
            /*
                This connects purchase to supplier
                Each purchase belongs to ONE supplier
                laravel behind the scene-> FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
                Laravel assumes > supplier_id → refers to id column,Table name → suppliers (plural of “supplier”)
            */
            $table->foreignId('supplier_id')
                ->constrained() // refers to 'suppliers' table
                ->cascadeOnDelete(); // delete purchases if supplier deleted

            // Total bill amount of the purchase
            $table->decimal('total_amount', 10, 2)->default(0);

            // Date when purchase happened
            $table->date('purchase_date');

            // Optional notes
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
