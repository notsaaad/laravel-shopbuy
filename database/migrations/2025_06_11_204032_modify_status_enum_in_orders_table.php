<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {

        DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'complete', 'cancelled') NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {

        DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'paid', 'shipped', 'cancelled') NOT NULL DEFAULT 'pending'");
    }
};
