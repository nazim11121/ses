<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBkashFieldsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('bkash_transaction_id')->nullable()->after('payment_method');
            $table->decimal('bkash_amount', 10, 2)->nullable()->after('bkash_transaction_id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['bkash_transaction_id', 'bkash_amount']);
        });
    }
}
