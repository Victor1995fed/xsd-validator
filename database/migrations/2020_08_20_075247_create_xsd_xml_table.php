<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXsdXmlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xsd_xml', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('xsd_id')->unsigned();
            $table->bigInteger('xml_id')->unsigned();
        });

        Schema::table('xsd_xml', function (Blueprint $table) {
            $table->foreign('xsd_id','fk-xsd_xml-xsd')->references('id')->on('xsd')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('xml_id','fk-xsd_xml-xml')->references('id')->on('files')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('xsd_xml', function (Blueprint $table) {
            $table->index('xsd_id','idx_xsd_xml_xsd_id');
            $table->index('xml_id','idx_xsd_xml_xml_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xsd_xml');
    }
}
