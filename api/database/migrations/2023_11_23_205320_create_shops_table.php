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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name')->unique()->comment('店舗名');
            $table->string('address')->comment('住所');
            $table->string('tel')->unique()->comment('電話番号');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->string('description')->nullable()->comment('店舗の説明');
            $table->softDeletesDatetime();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
