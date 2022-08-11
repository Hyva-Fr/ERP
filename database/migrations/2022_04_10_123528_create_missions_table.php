<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('serial');
            $table->string('review');
            $table->longText('distribution_plan')->nullable();
            $table->longText('clamping_plan')->nullable();
            $table->longText('electrical_diagram')->nullable();
            $table->longText('workshops_help')->nullable();
            $table->longText('receipt')->nullable();
            $table->longText('delivery_note')->nullable();
            $table->unsignedBigInteger('society_id');
            $table->foreign('society_id')->references('id')->on('societies')->onUpdate('cascade');
            $table->text('description')->nullable();
            $table->longText('images')->nullable();
            $table->boolean('done')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('missions');
    }
}
