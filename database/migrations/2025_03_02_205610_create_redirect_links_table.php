<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE_NAME = 'redirect_links';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->foreignId('link_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('link_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
