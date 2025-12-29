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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 64)->unique()->nullable();
            $table->string('name', 180);
            $table->string('slug', 200)->unique();
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->integer('stock');
            $table->boolean('is_active')->default(true);

            //Quitar cuando se cree category
            $table->unsignedBigInteger('category_id')->nullable();
            //$table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            //Indexes
            $table->index(['is_active', 'id']);
            $table->index(['category_id', 'id']);
            $table->index(['price', 'id']);
            $table->index(['created_at', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
