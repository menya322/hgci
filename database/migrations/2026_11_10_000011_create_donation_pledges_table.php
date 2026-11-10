<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donation_pledges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('UGX');
            $table->string('frequency')->default('one_time');
            $table->string('method')->nullable();
            $table->text('message')->nullable();
            $table->boolean('consent')->default(false);
            $table->string('status')->default('pending');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index('email');
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_pledges');
    }
};
