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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();

            // Connects item to purchase
            // Many items belong to ONE purchase
            $table->foreignId('purchase_id')
                ->constrained()
                ->cascadeOnDelete();

            // Connects item to product
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            // Quantity of this product in purchase
            $table->integer('qty');

            // Price per unit at time of purchase
            $table->decimal('price', 10, 2);

            // qty * price (store for performance/reporting)
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
