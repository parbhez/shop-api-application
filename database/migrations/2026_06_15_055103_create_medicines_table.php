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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('generic_name')->nullable();
            $table->string('strength')->nullable();
            $table->string('category')->default('herbal');
            $table->string('brand')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('strip_price', 10, 2)->nullable();
            $table->string('availability_status')->default('In Stock');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
