<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRiskLevelToYtt1Draft extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('y_t_t1_drafts', function (Blueprint $table) {
            $table->decimal('risk_level', 8, 2)->nullable();
            $table->decimal('propensity_level', 8, 2)->nullable();
            $table->decimal('exposure_level', 8, 2)->nullable();
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
        Schema::table('y_t_t1_drafts', function (Blueprint $table) {
            $table->dropColumn('risk_level');
            $table->dropColumn('propensity_level');
            $table->dropColumn('exposure_level');
            $table->dropColumn('take_num');
        });
    }
}
