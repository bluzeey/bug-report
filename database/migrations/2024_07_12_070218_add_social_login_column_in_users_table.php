<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('avatar')->nullable()->after('email');
            $table->string('user_id')->nullable()->after('avatar');
            $table->longText('social_token')->nullable()->after('user_id');
            $table->string('login_type')->nullable()->after('social_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn(['avatar','user_id','social_token','login_type']);
        });
    }
};

