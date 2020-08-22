<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXmlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xml', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->text('content');
            $table->bigInteger('user_id')->unsigned()->default(null);
            $table->boolean('public')->default(false);
            $table->string('hash')->default('');
        });

        Schema::table('xml', function (Blueprint $table) {
            $table->foreign('user_id','fk-xml-users')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('xml', function (Blueprint $table) {
            $table->index('user_id','idx_xml_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('xml', function (Blueprint $table) {
            $table->dropForeign('fk-xml-users');
        });
        Schema::dropIfExists('xml');
    }
}
