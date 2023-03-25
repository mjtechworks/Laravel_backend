<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('log_notificationable_id');
            $table->string('log_notificationable_type');
            $table->string('channel');
            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('log_notifications', function (Blueprint $table) {
            $table->index(['log_notificationable_type', 'log_notificationable_id'], 'idx_notification');
            $table->index(['channel', 'log_notificationable_type', 'log_notificationable_id'], 'idx_channel_notification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_log_notifications');
    }
}
