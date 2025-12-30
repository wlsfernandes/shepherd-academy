<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class DeveloperSetting extends Model
{
    use HasFactory, Auditable;

    protected $table = 'developer_settings';

    protected $fillable = [
        // Stripe
        'stripe_key',
        'stripe_secret',
        'stripe_product_id',
        'stripe_currency',

        // PayPal
        'paypal_live_client_id',
        'paypal_live_client_secret',
        'paypal_live_currency',

        // reCAPTCHA
        'recaptcha_site_key',
        'recaptcha_secret_key',

        // Analytics
        'analytics_property_id',

        // Queue
        'queue_connection',

        // Mail
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',

    ];

    protected $casts = [
        'aws_debug' => 'boolean',
    ];

    /**
     * Get the singleton developer settings record.
     * Always returns exactly one row.
     */
    public static function current(): self
    {
        return static::first() ?? static::create();
    }

    /**
     * Enforce singleton behavior.
     * Prevent multiple rows.
     */
    protected static function booted()
    {
        static::creating(function () {
            if (static::count() > 0) {
                throw new \RuntimeException(
                    'Only one developer settings record is allowed.'
                );
            }
        });

        static::updated(fn() => \Log::info('DEVELOPER SETTINGS updated fired'));
    }

    /**
     * Helper: check if Stripe is configured.
     */
    public function stripeEnabled(): bool
    {
        return !empty($this->stripe_key) && !empty($this->stripe_secret);
    }

    /**
     * Helper: check if PayPal is configured.
     */
    public function paypalEnabled(): bool
    {
        return !empty($this->paypal_live_client_id)
            && !empty($this->paypal_live_client_secret);
    }

    /**
     * Helper: check if AWS is configured.
     */
    public function awsEnabled(): bool
    {
        return !empty($this->aws_access_key_id)
            && !empty($this->aws_secret_access_key)
            && !empty($this->aws_bucket);
    }
}
