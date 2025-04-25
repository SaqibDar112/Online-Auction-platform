<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuctionIdToBidsTable extends Migration
{
    public function up()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->integer('auction_id')->after('id');  // Add auction_id column
            $table->foreign('auction_id')->references('id')->on('auctions')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropColumn('auction_id');
        });
    }
}
