<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('prd_name', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_id')->nullable();

            $table->foreign('cat_id')->references('id')->on('categories');
        });
    }

    public function down()
    {
        Schema::table('prd_name', function (Blueprint $table) {
            $table->dropForeign(['cat_id']);
            $table->dropColumn('cat_id');
        });

        Schema::dropIfExists('categories');
    }
}
