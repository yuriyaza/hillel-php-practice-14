<?php

namespace App\Http\Controllers;

use App\Services\UrlEncoderExeption;
use App\Services\UrlEncoderInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MinimizeUrlController
{
    public function index(Request $request, UrlEncoderInterface $urlEncoder): JsonResponse
    {
        try {
            $hostName = $request->server->get('HTTP_HOST');

            $originalUrl = $request->get('url');
            if (!$originalUrl) {
                throw new MinimizeUrlControllerException('URL is not defined', 400);
            }

            $shortUrl = $urlEncoder->convertToShortUrl($hostName, $originalUrl);

            return response()->json([
                'code' => 200,
                'shortUrl' => $shortUrl,
            ], 200);

        } catch (MinimizeUrlControllerException|UrlEncoderExeption $exception) {
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
