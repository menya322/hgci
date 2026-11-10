<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_applications', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->text('skills')->nullable();
            $table->string('availability')->nullable();
            $table->text('motivation')->nullable();
            $table->boolean('consent')->default(false);
            $table->string('status')->default('new');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index('email');
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_applications');
    }
};
