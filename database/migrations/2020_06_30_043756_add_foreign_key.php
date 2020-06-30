<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('xsd', function (Blueprint $table) {
            $table->foreign('user_id','fk-xsd-users')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->foreign('user_id','fk-tags-users')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });



        Schema::table('xsd_files', function (Blueprint $table) {
            $table->foreign('xsd_id','fk-xsd_files-xsd')->references('id')->on('xsd')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('file_id','fk-xsd_files-files')->references('id')->on('files')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('xsd_tags', function (Blueprint $table) {
            $table->foreign('xsd_id','fk-xsd_tags-xsd')->references('id')->on('xsd')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tag_id','fk-xsd_tags-tags')->references('id')->on('tags')->onDelete('cascade')->onUpdate('cascade');
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
            $table->dropForeign('fk-xsd-users');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign('fk-tags-users');
        });

        Schema::table('xsd_files', function (Blueprint $table) {
            $table->dropForeign('fk-xsd_files-xsd');
            $table->dropForeign('fk-xsd_files-files');
        });

        Schema::table('xsd_tags', function (Blueprint $table) {
            $table->dropForeign('fk-xsd_tags-xsd');
            $table->dropForeign('fk-xsd_tags-tags');
        });

    }
}
