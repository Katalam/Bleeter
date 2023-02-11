<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function flashMessage(?string $message = null, ?string $type = null): ?array
    {
        if (!$message && !$type) {
            return null;
        }

        if (!$message) {
            match ($type) {
                'success' => $message = 'Successfully saved.',
                'danger' => $message = 'An error has occurred.',
                default => null,
            };
        }

        return [
            'message' => $message,
            'type' => $type,
        ];
    }
}
