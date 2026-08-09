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
        Schema::create('backup_risks', function (Blueprint $table) {

        $table->id();
        $table->foreignId('backup_id')->constrained()->restrictOnDelete();
        $table->foreignId('risk_id')->constrained()->restrictOnDelete();
        $table->string('type', 50);
        $table->boolean('is_active')->default(true);
        $table->text('description')->nullable();
        $table->integer('delay_in_minutes')->nullable();
        $table->decimal('size_loss_percent', 5, 2)->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_risks');
    }
};
