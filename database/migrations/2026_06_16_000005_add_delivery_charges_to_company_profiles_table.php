<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->integer('dhaka_delivery_charge')->default(50)->after('active');
            $table->integer('outside_dhaka_delivery_charge')->default(100)->after('dhaka_delivery_charge');
        });
    }

    public function down()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn(['dhaka_delivery_charge', 'outside_dhaka_delivery_charge']);
        });
    }
};
