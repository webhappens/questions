<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uri')->nullable()->default(null);
            $table->string('scheme', 6)->nullable()->default(null);
            $table->string('host')->nullable()->default(null);
            $table->smallInteger('port')->unsigned()->nullable()->default(null);
            $table->string('path')->nullable()->default(null);
            $table->json('query')->nullable()->default(null);
            $table->string('fragment')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referers');
    }
}
