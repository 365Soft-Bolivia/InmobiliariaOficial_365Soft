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
            $table->decimal('price', 15, 2);
            $table->text('description')->nullable();
            $table->string('taxes')->nullable();
            $table->boolean('allow_purchase')->default(true);
            $table->decimal('superficie_util', 10, 2)->nullable();
            $table->decimal('superficie_construida', 10, 2)->nullable();
            $table->integer('ambientes')->nullable();
            $table->integer('habitaciones')->nullable();
            $table->integer('banos')->nullable();
            $table->integer('cocheras')->nullable();
            $table->integer('ano_construccion')->nullable();
            $table->enum('operacion', ['venta', 'alquiler', 'anticretico'])->default('venta');
            $table->decimal('comision', 5, 2)->nullable();
            $table->boolean('is_public')->default(false);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('hsn_sac_code')->nullable();
            $table->boolean('downloadable')->default(false);
            $table->string('downloadable_file')->nullable();
            $table->string('default_image')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('last_updated_by')->references('id')->on('users')->onDelete('set null');
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
