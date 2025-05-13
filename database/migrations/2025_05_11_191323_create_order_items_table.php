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
        Schema::create('order_items', function (Blueprint $table) {
          $table->id();
          $table->foreignId('order_id')->constrained()->onDelete('cascade');


          $table->string('product_title');
          $table->string('product_image')->nullable();


          $table->json('variant_attributes')->nullable();
          $table->decimal('unit_price', 10, 2);
          $table->unsignedInteger('quantity');
          $table->decimal('total_price', 10, 2);

          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
