<?php

namespace App\Http\Middleware;

use Closure;

class AddHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload');
        $response->headers->set('X-XSS-Protection','1; mode=block');
        $response->headers->set('X-Content-Type-Options','nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Expect-CT', 'max-age=7776000, enforce');
        $response->headers->set('Access-Control-Allow-Origin','null');
        $response->headers->set('Access-Control-Allow-Methods','GET,PUT,POST,DELETE');
        $response->headers->set('Access-Control-Allow-Headers','Content-Type, Authorization');
        $response->headers->set('X-Content-Security-Policy','img-src *; media-src * data:;');
        $response->headers->set('Cross-Origin-Embedder-Policy-Report-Only',"unsafe-none; report-to='default'");
        $response->headers->set('Cross-Origin-Embedder-Policy',"unsafe-none; report-to='default'");
        $response->headers->set('Cross-Origin-Opener-Policy-Report-Only',"same-origin; report-to='default'");
        $response->headers->set('Cross-Origin-Opener-Policy',"same-origin-allow-popups; report-to='default'");
        $response->headers->set('Cross-Origin-Resource-Policy','cross-origin');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Permissions-Policy','accelerometer=(), autoplay=(), camera=(), cross-origin-isolated=(), document-domain=(), encrypted-media=(), fullscreen=*, geolocation=(self), gyroscope=(), keyboard-map=(), magnetometer=(), microphone=(), midi=(), payment=*, picture-in-picture=(), publickey-credentials-get=(), screen-wake-lock=(), sync-xhr=(), usb=(), xr-spatial-tracking=(), gamepad=(), serial=(), window-placement=()');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');
        $response->headers->set('Content-Security-Policy','report-uri https://ems.kdglobalhealthcare.com');
        return $response;
    }
}
