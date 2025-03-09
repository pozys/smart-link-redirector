<?php

use App\Domain\Models\RedirectLink;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE_NAME = 'rules';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->text('rule_type');
            $table->foreignId('owner_id')
                ->nullable()
                ->constrained(self::TABLE_NAME)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignIdFor(RedirectLink::class)
                ->nullable()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('owner_id');
            $table->index('redirect_link_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
