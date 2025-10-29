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
            $table->string('name');
            $table->string('codigo_inmueble')->unique();
            $table->decimal('price', 12, 2);
            $table->decimal('superficie_util', 10, 2)->nullable();
            $table->decimal('superficie_construida', 10, 2)->nullable();
            $table->integer('ambientes')->nullable();
            $table->integer('habitaciones')->nullable();
            $table->integer('banos')->nullable();
            $table->integer('cocheras')->nullable();
            $table->year('ano_construccion')->nullable();
            $table->enum('operacion', ['venta', 'alquiler', 'anticretico'])->default('venta');
            $table->decimal('comision', 5, 2)->nullable()->comment('Porcentaje de comisión');
            $table->decimal('taxes', 10, 2)->nullable();
            $table->boolean('allow_purchase')->default(true);
            $table->boolean('is_public')->default(true);
            $table->boolean('downloadable')->default(false);
            $table->string('downloadable_file')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('product_category')->nullOnDelete();
            $table->foreignId('added_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('last_updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('hsn_sac_code')->nullable();
            $table->string('default_image')->nullable();
            // $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('sku')->unique()->nullable();
            $table->timestamps();
            
            // Índices para mejorar búsquedas
            $table->index('operacion');
            $table->index('is_public');
            $table->index(['price', 'operacion']);
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