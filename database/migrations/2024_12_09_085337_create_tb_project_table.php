<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProjectTable extends Migration
{
    public function up()
    {
        Schema::create('tb_project', function (Blueprint $table) {
            $table->id('id_project');  // Primary key
            $table->string('project');  // Project name
            $table->timestamps();      // Created at and updated at
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_project');
    }
}
