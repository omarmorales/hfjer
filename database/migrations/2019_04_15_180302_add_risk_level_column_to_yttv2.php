<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRiskLevelColumnToYttv2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ytt2_evaluations', function (Blueprint $table) {
            $table->decimal('risk_level', 8, 2)->nullable();
            $table->integer('take_num')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ytt2_evaluations', function (Blueprint $table) {
            $table->dropColumn('risk_level');
            $table->dropColumn('take_num');
        });
    }
}
