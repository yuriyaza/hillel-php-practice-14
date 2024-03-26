<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MinimizeUrlValidation
{
    public function handle(Request $request, Closure $next): Response
    {
        $validateResult = Validator::make(
            $request->all(),
            [
                'url' => ['required', 'regex:/^.+\..+$/'],
            ],
            [
                'required' => 'Parameter :attribute is not defined',
                'regex' => 'Parameter :attribute is incorrect',
            ]
        );

        if ($validateResult->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validateResult->errors()->first(),
            ], 400);
        }
        return $next($request);
    }
}
