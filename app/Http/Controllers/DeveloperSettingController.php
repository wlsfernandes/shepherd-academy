<?php

namespace App\Http\Controllers;

use App\Models\DeveloperSetting;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use Stripe\StripeClient;
use Illuminate\Http\JsonResponse;
use Exception;

class DeveloperSettingController extends BaseController
{
    /**
     * Entry point (admin menu).
     * Redirects to edit screen.
     */
    public function index()
    {
        return redirect()->route('developer-settings.edit');
    }

    /**
     * Show developer settings form.
     * ⚠️ DANGEROUS – developer use only.
     */
    public function edit()
    {
        $setting = DeveloperSetting::current();

        return view('admin.developer_settings.form', compact('setting'));
    }

    /**
     * Update developer settings.
     * ⚠️ Changes here can break the site.
     */
    public function update(Request $request)
    {
        // ✅ Validation FIRST
        $data = $this->validatedData($request);

        $setting = DeveloperSetting::current();

        try {
            $setting->update($this->sanitizeSecrets($data, $setting));

            SystemLogger::log(
                'Developer settings updated',
                'warning',
                'developer_settings.update',
                [
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('developer-settings.edit')
                ->with('success', 'Developer settings updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Developer settings update failed',
                'error',
                'developer_settings.update',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update developer settings.');
        }
    }

    /**
     * Validation rules (strict).
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            // Stripe
            'stripe_key' => ['nullable', 'string'],
            'stripe_secret' => ['nullable', 'string'],
            'stripe_product_id' => ['nullable', 'string'],
            'stripe_currency' => ['nullable', 'string', 'max:10'],

            // PayPal
            'paypal_live_client_id' => ['nullable', 'string'],
            'paypal_live_client_secret' => ['nullable', 'string'],
            'paypal_live_currency' => ['nullable', 'string', 'max:10'],

            // reCAPTCHA
            'recaptcha_site_key' => ['nullable', 'string'],
            'recaptcha_secret_key' => ['nullable', 'string'],

            // Analytics
            'analytics_property_id' => ['nullable', 'string'],

            // Queue
            'queue_connection' => ['nullable', 'string'],

            // Mail
            'mail_mailer' => ['nullable', 'string'],
            'mail_host' => ['nullable', 'string'],
            'mail_port' => ['nullable', 'integer'],
            'mail_username' => ['nullable', 'string'],
            'mail_password' => ['nullable', 'string'],
            'mail_encryption' => ['nullable', 'string'],
            'mail_from_address' => ['nullable', 'email'],
            'mail_from_name' => ['nullable', 'string'],

            // AWS / S3
            'aws_access_key_id' => ['nullable', 'string'],
            'aws_secret_access_key' => ['nullable', 'string'],
            'aws_default_region' => ['nullable', 'string'],
            'aws_bucket' => ['nullable', 'string'],
            'aws_debug' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Do not overwrite secrets if input is masked/empty.
     */
    protected function sanitizeSecrets(array $data, DeveloperSetting $setting): array
    {
        $secretFields = [
            'stripe_secret',
            'paypal_live_client_secret',
            'recaptcha_secret_key',
            'mail_password',
            'aws_secret_access_key',
        ];

        foreach ($secretFields as $field) {
            if (empty($data[$field])) {
                unset($data[$field]);
            }
        }

        return $data;
    }

    public function testStripe(): JsonResponse
    {
        try {
            $secret = config('services.stripe.secret');

            if (empty($secret)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stripe secret key is not configured.',
                ], 400);
            }

            $stripe = new StripeClient($secret);

            // ✅ CORRECT Stripe SDK call
            $account = $stripe->accounts->retrieve();

            return response()->json([
                'success' => true,
                'message' => 'Stripe connection successful.',
                'account_id' => $account->id,
                'country' => $account->country,
                'email' => $account->email ?? null,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stripe connection failed.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
