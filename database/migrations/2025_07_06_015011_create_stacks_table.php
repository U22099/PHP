<?php

use App\Models\Projects;
use App\Models\Stacks;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stacks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('projects_stacks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Projects::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Stacks::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stacks');
        Schema::dropIfExists('projects_stacks');
    }
};
