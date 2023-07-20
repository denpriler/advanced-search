<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parser_statuses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parser_id');
            $table->foreign('parser_id')
                ->references('id')
                ->on('parsers')
                ->cascadeOnDelete();

            $table->string('status');
            $table->text('status_reason')->nullable();
            $table->string('proxies_alive');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parser_statuses');
    }
};
