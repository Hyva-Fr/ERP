<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsAgencyIdToValidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('validates', function (Blueprint $table) {
            $table->unsignedBigInteger('agency_id')->after('id');
            $table->foreign('agency_id')->references('id')->on('agencies')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('validates', function (Blueprint $table) {
            $table->dropColumn(['agency_id']);
        });
    }
}
