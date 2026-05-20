<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->nullable();
            $table->enum('type', ['book', 'journal', 'ebook', 'research_paper'])->default('book');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->integer('published_year')->nullable();
            $table->string('publisher')->nullable();
            $table->integer('pages')->nullable();
            $table->string('language')->default('English');
            $table->enum('status', ['available', 'borrowed', 'reserved'])->default('available');
            $table->decimal('rating', 2, 1)->default(0);
            $table->integer('views')->default(0);
            $table->integer('total_copies')->default(1);
            $table->integer('available_copies')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
