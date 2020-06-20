<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXsdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xsd', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('file_uuid')->default('');
            $table->integer('user_id')->default(null);
            $table->string('title');
            $table->text('description');
            $table->string('root_xsd')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xsd');
    }
}
