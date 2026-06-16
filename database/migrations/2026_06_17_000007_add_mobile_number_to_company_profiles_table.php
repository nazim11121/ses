<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->string('mobile_number')->nullable()->after('phone');
        });
    }

    public function down()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn('mobile_number');
        });
    }
};
