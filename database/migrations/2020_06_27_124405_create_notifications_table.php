<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('notifications', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        Schema::create('tbl_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notification_unique_id', 80)->unique();
            $table->string('title');
            $table->string('body');
            $table->string('icon');
            $table->json('subscribed_users')->nullable()->default(null);
            $table->string('user_unique_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_notifications');
    }
}
