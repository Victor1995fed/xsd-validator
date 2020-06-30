<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeColumnFromForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('xsd', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
        });

        Schema::table('xsd_tags', function (Blueprint $table) {
            $table->bigInteger('xsd_id')->unsigned()->change();
            $table->bigInteger('tag_id')->unsigned()->change();
        });

        Schema::table('xsd_files', function (Blueprint $table) {
            $table->bigInteger('xsd_id')->unsigned()->change();
            $table->bigInteger('file_id')->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('xsd', function (Blueprint $table) {
            $table->integer('user_id')->unsigned(false)->change();
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->integer('user_id')->unsigned(false)->change();
        });

        Schema::table('xsd_tags', function (Blueprint $table) {
            $table->integer('xsd_id')->unsigned(false)->change();
            $table->integer('tag_id')->unsigned(false)->change();
        });

        Schema::table('xsd_files', function (Blueprint $table) {
            $table->integer('xsd_id')->unsigned(false)->change();
            $table->integer('file_id')->unsigned(false)->change();
        });
    }
}
