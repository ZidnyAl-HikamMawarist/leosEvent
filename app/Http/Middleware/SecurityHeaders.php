<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * Adds security-related HTTP response headers to protect against
     * common web vulnerabilities:
     *   - CSP  : Content-Security-Policy (XSS & data injection)
     *   - HSTS : Strict-Transport-Security (SSL stripping / MITM)
     *   - X-Frame-Options  : Clickjacking protection
     *   - X-Content-Type-Options : MIME-sniffing protection
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // ── Content Security Policy ────────────────────────────────────────
        // Allow resources from self, trusted CDNs, and Google Fonts.
        // Adjust the policy as your app evolves (e.g. add nonce for inline scripts).
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com https://unpkg.com",
            "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net",
            "img-src 'self' data: blob: https:",
            "connect-src 'self'",
            "frame-ancestors 'none'",
        ]);
        $response->headers->set('Content-Security-Policy', $csp);

        // ── HTTP Strict Transport Security ─────────────────────────────────
        // Only set HSTS on HTTPS connections to avoid breaking local HTTP dev.
        if ($request->secure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        // ── Clickjacking Protection ────────────────────────────────────────
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // ── MIME-Sniffing Protection ───────────────────────────────────────
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // ── Referrer Policy (bonus hardening) ─────────────────────────────
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}
