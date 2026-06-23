<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourierFieldsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('courier_provider')->nullable()->after('status');
            $table->string('courier_tracking_number')->nullable()->after('courier_provider');
            $table->string('courier_status')->nullable()->after('courier_tracking_number');
            $table->json('courier_payload')->nullable()->after('courier_status');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['courier_provider', 'courier_tracking_number', 'courier_status', 'courier_payload']);
        });
    }
}
