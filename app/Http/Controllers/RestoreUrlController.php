<?php

namespace App\Http\Controllers;

use App\Services\UrlEncoderExeption;
use App\Services\UrlEncoderInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class RestoreUrlController
{
    public function index(string $shortUrl, UrlEncoderInterface $urlEncoder): RedirectResponse|JsonResponse
    {
        try {
            $originalUrl = $urlEncoder->convertToOriginalUrl($shortUrl);

            return Redirect::to($originalUrl);

        } catch (RestoreUrlControllerException|UrlEncoderExeption $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ], $exception->getCode());

        } catch (\Exception $exception) {
            return response()->json([
                'code' => 500,
                'message' => 'Internal server error',
            ], 500);
        }
    }
}
