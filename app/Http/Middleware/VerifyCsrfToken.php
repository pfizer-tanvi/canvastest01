<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * @codeCoverageIgnore
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'pfizer_login/*'
    ];
    /**
     * Add the CSRF token to the response cookies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return \Illuminate\Http\Response
     */
    protected function addCookieToResponse($request, $response)
    {
        $response->headers->setCookie(
            new Cookie('XSRF-TOKEN', $request->session()->token(), 0, '/', null, true, true)
        );

        return $response;
    }

    public function handle($request, \Closure $next)
    {
        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $e) {
            if ($request->isXmlHttpRequest() || $request->isJson()) {
                return response()->json(['message' => 'Token has expired']);
            }

            return redirect()
                ->back()
                ->withErrors(['Session has expired. Please try again'])
                ->withInput($request->except('password'));
        }
    }

    /**
     * Get the CSRF token from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function getTokenFromRequest($request)
    {
        $token = $request->input('_token');

        if (!$token) {
            $token = $request->cookie('XSRF-TOKEN');
        }

        if (!$token && $header = $request->header('X-XSRF-TOKEN')) {
            /** doing this since encrypter wants string and header returns array|string */
            $header = Arr::first(Arr::wrap($header));
            $token = $this->encrypter->decrypt($header, static::serialized());
        }

        return $token;
    }
}
