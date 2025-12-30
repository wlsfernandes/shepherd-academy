<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('developer_settings', function (Blueprint $table) {
            $table->id();
            /*
            |--------------------------------------------------------------------------
            | AWS / S3
            |--------------------------------------------------------------------------
            */
            $table->string('aws_access_key_id')->nullable();
            $table->string('aws_secret_access_key')->nullable();
            $table->string('aws_default_region')->nullable();
            $table->string('aws_bucket')->nullable();
            $table->boolean('aws_debug')->default(false);
            /*
            |--------------------------------------------------------------------------
            | STRIPE
            |--------------------------------------------------------------------------
            */
            $table->string('stripe_key')->nullable();
            $table->string('stripe_secret')->nullable();
            $table->string('stripe_product_id')->nullable();
            $table->string('stripe_currency')->default('usd');

            /*
            |--------------------------------------------------------------------------
            | PAYPAL
            |--------------------------------------------------------------------------
            */
            $table->string('paypal_live_client_id')->nullable();
            $table->string('paypal_live_client_secret')->nullable();
            $table->string('paypal_live_currency')->default('usd');

            /*
            |--------------------------------------------------------------------------
            | RECAPTCHA
            |--------------------------------------------------------------------------
            */
            $table->string('recaptcha_site_key')->nullable();
            $table->string('recaptcha_secret_key')->nullable();

            /*
            |--------------------------------------------------------------------------
            | ANALYTICS
            |--------------------------------------------------------------------------
            */
            $table->string('analytics_property_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | QUEUE
            |--------------------------------------------------------------------------
            */
            $table->string('queue_connection')->default('sync');

            /*
            |--------------------------------------------------------------------------
            | MAIL
            |--------------------------------------------------------------------------
            */
            $table->string('mail_mailer')->default('smtp');
            $table->string('mail_host')->nullable();
            $table->integer('mail_port')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_encryption')->nullable();
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('developer_settings');
    }
};
