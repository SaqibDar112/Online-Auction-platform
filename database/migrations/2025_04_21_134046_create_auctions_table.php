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
         Schema::create('auctions', function (Blueprint $table) {
             $table->id();
             $table->string('title');
             $table->text('description');
             $table->decimal('starting_price', 8, 2);
             $table->timestamp('ends_at');
             $table->foreignId('user_id')->constrained()->onDelete('cascade');
             $table->timestamps();
         });
     }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
