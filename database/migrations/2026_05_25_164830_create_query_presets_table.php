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
        Schema::create('query_presets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('クエリ名');
            $table->jsonb('display_columns')->comment('表示項目');
            $table->jsonb('conditions')->comment('検索条件');
            $table->integer('mst_user_id')->comment('作成ユーザID');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('query_presets');
    }
};
