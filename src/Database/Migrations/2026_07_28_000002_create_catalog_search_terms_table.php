<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('catalog_search_terms')) {
            return;
        }

        Schema::create('catalog_search_terms', function (Blueprint $table): void {
            $table->id();
            $table->string('term', 120)->unique();
            $table->unsignedBigInteger('count')->default(1);
            $table->timestamp('last_searched_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_search_terms');
    }
};
