<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationLogsTable extends Migration
{
    public function up()
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['mail', 'sms']);
            $table->string('driver')->nullable();
            $table->string('recipient'); // email or phone number
            $table->string('subject')->nullable(); // mail only
            $table->text('message');
            $table->enum('status', ['sent', 'failed']);
            $table->text('error')->nullable();
            $table->foreignId('notification_setting_id')->nullable()->constrained('notification_settings')->nullOnDelete();
            $table->foreignId('notification_template_id')->nullable()->constrained('notification_templates')->nullOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_logs');
    }
}
