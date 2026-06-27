<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Mail\Mailable;
use Throwable;
use App\Services\LogService;

class MailService
{
    /**
     * Send an email asynchronously (push to queue).
     * This is the recommended approach for API performance.
     *
     * @param mixed $to Email address(es) or User model(s)
     * @param Mailable $mailable The mail class instance
     * @return bool
     */
    public function sendAsync(mixed $to, Mailable $mailable): bool
    {
        try {
            Mail::to($to)->queue($mailable);
            return true;
        } catch (Throwable $e) {
            LogService::exception($e, 'Failed to queue email', [
                'to' => $to,
                'mailable' => get_class($mailable),
            ]);
            return false;
        }
    }

    /**
     * Send an email synchronously (blocking).
     * Use this only when the system must wait for the email to be delivered.
     *
     * @param mixed $to Email address(es) or User model(s)
     * @param Mailable $mailable The mail class instance
     * @return bool
     */
    public function sendSync(mixed $to, Mailable $mailable): bool
    {
        try {
            Mail::to($to)->send($mailable);
            return true;
        } catch (Throwable $e) {
            LogService::exception($e, 'Failed to send email synchronously', [
                'to' => $to,
                'mailable' => get_class($mailable),
            ]);
            return false;
        }
    }
}
