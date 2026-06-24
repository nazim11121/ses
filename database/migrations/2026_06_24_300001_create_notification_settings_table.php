<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['mail', 'sms']);
            $table->string('driver'); // smtp, mailgun, ses, ssl_wireless, twilio, infobip
            $table->string('label');
            $table->json('settings'); // driver-specific credentials/config
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_settings');
    }
}
