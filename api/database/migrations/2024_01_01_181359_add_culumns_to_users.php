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
            $table->string('payjp_customer_id')->nullable()->after('remember_token')->comment('payjpの顧客ID');
            $table->string('payjp_current_card_id')->nullable()->after('payjp_customer_id')->comment('現在設定されているカードID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('payjp_current_card_id');
            $table->dropColumn('payjp_customer_id');
        });
    }
};
