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
        // Tabla "countries"
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('codigo_iso');
            $table->timestamps();
        });


        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('numeric_code');
            $table->foreignId('countrie_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla "state"
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Tabla "roles"
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->foreignId('state_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla "events"
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
        });

        // Tabla "type_documents"
        Schema::create('type_documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iso_name');
            $table->unsignedBigInteger('state_id');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "type_payments"
        Schema::create('type_payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iso_name');
            $table->unsignedBigInteger('state_id');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "method_payments"
        Schema::create('method_payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iso_name');
            $table->unsignedBigInteger('state_id');
            $table->string('description');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "customers"
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('representative')->nullable();
            $table->string('address')->nullable();
            $table->string('cell_phone')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('type_document');
            $table->integer('document')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('countrie_id');
            $table->unsignedBigInteger('state_id');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('type_document')->references('id')->on('type_documents')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('countrie_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "users"
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->unsignedBigInteger('type_document');
            $table->integer('document')->nullable();
            $table->string('cell_phone')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('countrie_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('type_document')->references('id')->on('type_documents')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('countrie_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "categories"
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "brands"
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "products"
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->integer('price');
            $table->integer('stock');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "images_products"
        Schema::create('images_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('image');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "invoices"
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_payments');
            $table->unsignedBigInteger('method_payment');
            $table->integer('value_total');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('state_id');
            $table->string('shipment')->nullable();
            $table->timestamp('expiration_date')->nullable();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('type_payments')->references('id')->on('type_payments')->onDelete('cascade');
            $table->foreign('method_payment')->references('id')->on('method_payments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "detail_invoices"
        Schema::create('detail_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "taxes"
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "product_taxes"
        Schema::create('product_taxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('taxes_id');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('taxes_id')->references('id')->on('taxes')->onDelete('cascade');
        });

        // Tabla "bitacora"
        Schema::create('bitacora', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('events_id');
            $table->string('table');
            $table->string('field_old')->nullable();
            $table->string('field_new')->nullable();
            $table->string('description');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamp('update_date')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('events_id')->references('id')->on('events')->onDelete('cascade');
        });

        // Tabla "ratings"
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('value');
            $table->string('comments')->nullable();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        // Tabla "type_discounts"
        Schema::create('type_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        // Tabla "coupons"
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->unsignedBigInteger('type_discount');
            $table->unsignedBigInteger('value_discount');
            $table->integer('amount');
            $table->timestamp('init_date');
            $table->timestamp('expiration_date');
            $table->string('terms_use')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamps();
            $table->foreign('type_discount')->references('id')->on('type_discounts')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('states');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('events');
        Schema::dropIfExists('type_documents');
        Schema::dropIfExists('type_payments');
        Schema::dropIfExists('method_payments');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('users');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('products');
        Schema::dropIfExists('images_products');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('detaill_invoices');
        Schema::dropIfExists('taxes');
        Schema::dropIfExists('product_taxes');
        Schema::dropIfExists('bitacora');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('type_discounts');
        Schema::dropIfExists('coupons');
    }
};
