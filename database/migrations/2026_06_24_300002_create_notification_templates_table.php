<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['mail', 'sms', 'both']);
            $table->string('subject')->nullable(); // mail only
            $table->text('body'); // supports {customer_name}, {order_id}, etc.
            $table->json('variables')->nullable(); // list of available placeholder variables
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_templates');
    }
}
