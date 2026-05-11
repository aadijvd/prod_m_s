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
        //changing name to suppliers
        Schema::rename('customers', 'suppliers');
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('suppliers', 'customers');
    }
};
