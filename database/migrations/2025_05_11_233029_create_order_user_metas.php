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
        Schema::create('order_user_metas', function (Blueprint $table) {
          $table->id();
          $table->foreignId('order_id')->constrained()->onDelete('cascade');
          $table->string('name');
          $table->string('email')->nullable();
          $table->string('phone')->nullable();
          $table->string('country')->nullable();
          $table->string('city')->nullable();
          $table->string('address')->nullable();
          $table->string('postal_code')->nullable();

          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_user_meta');
    }
};
