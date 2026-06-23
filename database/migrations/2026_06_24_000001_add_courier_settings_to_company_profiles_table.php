<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->string('default_courier_provider')->nullable()->after('active');
            $table->json('courier_settings')->nullable()->after('default_courier_provider');
        });
    }

    public function down()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn(['default_courier_provider', 'courier_settings']);
        });
    }
};
