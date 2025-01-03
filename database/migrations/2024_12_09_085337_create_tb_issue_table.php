<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbIssueTable extends Migration
{
    public function up()
    {
        Schema::create('tb_issue', function (Blueprint $table) {
            $table->id('id_issue');    // Primary key
            $table->integer('id_project');  
            $table->text('issue_desc'); // Issue description
            $table->string('pic');      // Picture or other related data
            $table->text('note');       // Additional notes
            $table->integer('priority');  // Issue priority (e.g., 1-5)
            $table->timestamps();      // Created at and updated at
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_issue');
    }
}
