<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->string('owner_name')->nullable()->after('name');
            $table->string('company_logo')->nullable()->after('owner_name');
            $table->string('favicon_icon')->nullable()->after('company_logo');
        });
    }

    public function down()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn(['owner_name', 'company_logo', 'favicon_icon']);
        });
    }
};
