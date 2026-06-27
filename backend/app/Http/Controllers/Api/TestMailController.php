<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mail\TestEmailRequest;
use App\Actions\Mail\SendTestEmailAction;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class TestMailController extends Controller
{
    use ApiResponse;

    /**
     * Send a test email.
     *
     * @param TestEmailRequest $request
     * @param SendTestEmailAction $action
     * @return JsonResponse
     */
    public function send(TestEmailRequest $request, SendTestEmailAction $action): JsonResponse
    {
        $success = $action($request->validated());

        if ($success) {
            return $this->successResponse(null, 'Test email queued successfully');
        }

        // If $success is false, it means MailService caught an exception and logged it.
        // We return a 500 error, but our global exception handler could also handle exceptions if we threw one.
        // Returning a generic error is safer than crashing.
        return $this->errorResponse('Failed to send test email. Please check the logs.', 500);
    }
}
