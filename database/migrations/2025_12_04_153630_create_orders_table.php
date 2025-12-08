<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('order_code');
        $table->string('customer_name');
        $table->integer('total_amount');
        $table->enum('status',['paid','pending','delivered','cancelled'])->default('pending');
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
