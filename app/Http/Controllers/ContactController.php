<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // 1. Honeypot: bots yang mengisi field ini langsung ditolak secara diam-diam
        if ($request->filled('website_url')) {
            Log::info('contact blocked', ['reason' => 'honeypot', 'ip' => $request->ip()]);

            return redirect()->back()->with('success', 'Message sent successfully! Thank you.');
        }

        // 2. Time trap: tolak jika submit terlalu cepat (< 3 detik) atau token expired (> 2 jam)
        if (! $this->isTokenValid($request->input('form_token', ''))) {
            Log::info('contact blocked', ['reason' => 'time_trap', 'ip' => $request->ip()]);

            return redirect()->back()->with('success', 'Message sent successfully! Thank you.');
        }

        // 3. Validasi struktural (aturan ada di FormRequest)
        $validated = $request->validate(
            (new StoreContactMessageRequest)->rules(),
            (new StoreContactMessageRequest)->messages(),
        );

        // 4. Cloudflare Turnstile (opsional — hanya aktif jika kunci dikonfigurasi)
        if (config('services.turnstile.secret_key') && $this->turnstileFails($request)) {
            Log::info('contact blocked', ['reason' => 'turnstile', 'ip' => $request->ip()]);

            return redirect()->back()->with('success', 'Message sent successfully! Thank you.');
        }

        // 5. Per-email rate limit: maks 3 pesan per jam dari email yang sama
        $emailKey = 'contact:email:'.sha1(strtolower($validated['email']));
        if (RateLimiter::tooManyAttempts($emailKey, 3)) {
            Log::info('contact blocked', ['reason' => 'email_throttle', 'ip' => $request->ip()]);

            return redirect()->back()->with('success', 'Message sent successfully! Thank you.');
        }
        RateLimiter::hit($emailKey, 3600);

        // 6. Simpan pesan (strip_tags sebelum menyimpan)
        Message::create([
            'name' => strip_tags($validated['name']),
            'email' => $validated['email'],
            'message' => strip_tags($validated['message']),
        ]);

        return redirect()->back()->with('success', 'Message sent successfully! Thank you.');
    }

    private function isTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        try {
            $timestamp = (int) Crypt::decryptString($token);
            $age = time() - $timestamp;

            return $age >= 3 && $age <= 7200;
        } catch (\Exception) {
            return false;
        }
    }

    private function turnstileFails(Request $request): bool
    {
        try {
            $response = Http::asForm()->timeout(5)->post(
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                [
                    'secret' => config('services.turnstile.secret_key'),
                    'response' => $request->input('cf-turnstile-response', ''),
                    'remoteip' => $request->ip(),
                ]
            );

            return $response->json('success') !== true;
        } catch (\Exception $e) {
            // Fail open: jika Turnstile tidak bisa dihubungi, biarkan request lewat
            Log::error('Turnstile verification failed: '.$e->getMessage());

            return false;
        }
    }
}
