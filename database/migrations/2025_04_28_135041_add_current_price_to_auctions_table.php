<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrentPriceToAuctionsTable extends Migration
{
    public function up()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->decimal('current_price', 10, 2)->nullable()->after('starting_price');
        });
    }

    public function down()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn('current_price');
        });
    }
}