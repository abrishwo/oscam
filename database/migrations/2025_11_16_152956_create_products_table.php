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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('qr_code')->unique();
        $table->string('product_name');
        $table->string('batch_number')->nullable();
        $table->enum('status', ['original', 'fake'])->default('original');
        $table->integer('scan_count')->default(0);
        $table->timestamp('last_scan')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
