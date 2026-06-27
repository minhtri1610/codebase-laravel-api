<?php

namespace App\Actions\Mail;

use App\Services\MailService;
use App\Mail\TestEmail;

class SendTestEmailAction
{
    protected MailService $mailService;

    /**
     * Inject MailService dependency via constructor.
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Execute the action.
     *
     * @param array<string, mixed> $data
     * @return bool
     */
    public function __invoke(array $data): bool
    {
        // Build the mailable instance
        $mail = new TestEmail($data['title'], $data['content']);
        
        // Dispatch asynchronously using our MailService
        return $this->mailService->sendAsync($data['email'], $mail);
    }
}
