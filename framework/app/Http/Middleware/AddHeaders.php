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
        $response->header('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload');
        $response->header('X-XSS-Protection','1; mode=block');
        $response->header('X-Content-Type-Options','nosniff');
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->header('Expect-CT', 'max-age=7776000, enforce');
        $response->header('Access-Control-Allow-Origin','null');
        $response->header('Access-Control-Allow-Methods','GET,PUT,POST,DELETE');
        $response->header('Access-Control-Allow-Headers','Content-Type, Authorization');
        $response->header('X-Content-Security-Policy','img-src *; media-src * data:;');
        $response->header('Cross-Origin-Embedder-Policy-Report-Only',"unsafe-none; report-to='default'");
        $response->header('Cross-Origin-Embedder-Policy',"unsafe-none; report-to='default'");
        $response->header('Cross-Origin-Opener-Policy-Report-Only',"same-origin; report-to='default'");
        $response->header('Cross-Origin-Opener-Policy',"same-origin-allow-popups; report-to='default'");
        $response->header('Cross-Origin-Resource-Policy','cross-origin');
        $response->header('X-Frame-Options', 'SAMEORIGIN');
        $response->header('Permissions-Policy','accelerometer=(), autoplay=(), camera=(), cross-origin-isolated=(), document-domain=(), encrypted-media=(), fullscreen=*, geolocation=(self), gyroscope=(), keyboard-map=(), magnetometer=(), microphone=(), midi=(), payment=*, picture-in-picture=(), publickey-credentials-get=(), screen-wake-lock=(), sync-xhr=(), usb=(), xr-spatial-tracking=(), gamepad=(), serial=(), window-placement=()');
        $response->header('X-Permitted-Cross-Domain-Policies', 'none');
        $response->header('Content-Security-Policy','report-uri https://ems.kdglobalhealthcare.com');
        return $response;
    }
}
