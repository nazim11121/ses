<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('content');
            $table->string('sidebar_title')->nullable();
            $table->text('sidebar_text')->nullable();
            $table->string('feature_one_title')->nullable();
            $table->text('feature_one_text')->nullable();
            $table->string('feature_two_title')->nullable();
            $table->text('feature_two_text')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
