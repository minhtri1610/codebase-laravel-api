<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Throwable;

class LogService
{
    /**
     * Log an informational message.
     *
     * @param string $message
     * @param array<string, mixed> $context
     * @param string|null $channel
     * @return void
     */
    public static function info(string $message, array $context = [], ?string $channel = null): void
    {
        self::log('info', $message, $context, $channel);
    }

    /**
     * Log a warning message.
     *
     * @param string $message
     * @param array<string, mixed> $context
     * @param string|null $channel
     * @return void
     */
    public static function warning(string $message, array $context = [], ?string $channel = null): void
    {
        self::log('warning', $message, $context, $channel);
    }

    /**
     * Log an error message.
     *
     * @param string $message
     * @param array<string, mixed> $context
     * @param string|null $channel
     * @return void
     */
    public static function error(string $message, array $context = [], ?string $channel = null): void
    {
        self::log('error', $message, $context, $channel);
    }

    /**
     * Log an exception with detailed trace and context.
     *
     * @param Throwable $exception
     * @param string $message
     * @param array<string, mixed> $context
     * @param string|null $channel
     * @return void
     */
    public static function exception(Throwable $exception, string $message = 'An exception occurred', array $context = [], ?string $channel = null): void
    {
        $context = array_merge($context, [
            'exception_message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        self::error($message, $context, $channel);
    }

    /**
     * Internal method to process and format logs.
     *
     * @param string $level
     * @param string $message
     * @param array<string, mixed> $context
     * @param string|null $channel
     * @return void
     */
    protected static function log(string $level, string $message, array $context = [], ?string $channel = null): void
    {
        // Auto-inject authenticated user ID if available
        if (auth()->check()) {
            $context['user_id'] = auth()->id();
        }

        // Auto-inject request URL and IP if running in an HTTP context
        if (request()) {
            $context['url'] = request()->fullUrl();
            $context['ip'] = request()->ip();
        }

        if ($channel) {
            Log::channel($channel)->log($level, $message, $context);
        } else {
            Log::log($level, $message, $context);
        }
    }
}
