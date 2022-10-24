<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowablesTable extends Migration
{
    public function up()
    {
        Schema::create(config('follow.followables_table', 'followables'), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(config('follow.user_foreign_key', 'user_id'))->index()->comment('user_id');
            if (config('follow.uuids')) {
                $table->uuidMorphs('followable');
            } else {
                $table->morphs('followable');
            }
            $table->dateTime('followed_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('follow.followables_table', 'followables'));
    }
}
