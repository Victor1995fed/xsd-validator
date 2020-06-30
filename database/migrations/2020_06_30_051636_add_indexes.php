<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('xsd', function (Blueprint $table) {
            $table->index('user_id','idx_xsd_user_id');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->index('user_id','idx_tags_user_id');
        });

        Schema::table('xsd_tags', function (Blueprint $table) {
            $table->index('xsd_id','idx_xsd_tags_xsd_id');
            $table->index('tag_id','idx_xsd_tags_tag_id');
        });

        Schema::table('xsd_files', function (Blueprint $table) {
            $table->index('xsd_id','idx_xsd_files_xsd_id');
            $table->index('file_id','idx_xsd_files_file_id');
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
            $table->dropIndex('idx_xsd_user_id');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropIndex('idx_tags_user_id');
        });

        Schema::table('xsd_files', function (Blueprint $table) {
            $table->dropIndex('idx_xsd_files_xsd_id');
            $table->dropIndex('idx_xsd_files_file_id');
        });
        Schema::table('xsd_tags', function (Blueprint $table) {
            $table->dropIndex('idx_xsd_tags_xsd_id');
            $table->dropIndex('idx_xsd_tags_tag_id');
        });
    }
}
