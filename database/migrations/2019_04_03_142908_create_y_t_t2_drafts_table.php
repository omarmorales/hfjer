<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYTT2DraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('y_t_t2_drafts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('age')->nullable();

            $table->string('folio')->nullable();
            $table->integer('beneficiary_id')->unsigned();

            $table->integer('answer1')->nullable();
            $table->integer('answer2')->nullable();
            $table->integer('answer3')->nullable();
            $table->integer('answer4')->nullable();
            $table->integer('answer5')->nullable();
            $table->integer('answer6')->nullable();
            $table->integer('answer7')->nullable();
            $table->integer('answer8')->nullable();
            $table->integer('answer9')->nullable();
            $table->integer('answer10')->nullable();
            $table->integer('answer11')->nullable();
            $table->integer('answer12')->nullable();
            $table->integer('answer13')->nullable();
            $table->integer('answer14')->nullable();
            $table->integer('answer15')->nullable();
            $table->integer('answer16')->nullable();
            $table->integer('answer17')->nullable();
            $table->integer('answer18')->nullable();
            $table->integer('answer19')->nullable();
            $table->integer('answer20')->nullable();


            $table->mediumText('information1')->nullable();
            $table->mediumText('information2')->nullable();
            $table->mediumText('information3')->nullable();
            $table->mediumText('information4')->nullable();
            $table->mediumText('information5')->nullable();
            $table->mediumText('information6')->nullable();
            $table->mediumText('information7')->nullable();
            $table->mediumText('information8')->nullable();
            $table->mediumText('information9')->nullable();
            $table->mediumText('information10')->nullable();
            $table->mediumText('information11')->nullable();
            $table->mediumText('information12')->nullable();
            $table->mediumText('information13')->nullable();
            $table->mediumText('information14')->nullable();
            $table->mediumText('information15')->nullable();
            $table->mediumText('information16')->nullable();
            $table->mediumText('information17')->nullable();
            $table->mediumText('information18')->nullable();
            $table->mediumText('information19')->nullable();
            $table->mediumText('information20')->nullable();

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
        Schema::dropIfExists('y_t_t2_drafts');
    }
}
