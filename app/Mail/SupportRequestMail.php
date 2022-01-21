<?php

namespace App\Mail;

use App\Models\SupportRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var SupportRequest $supportRequest
     */
    public $supportRequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SupportRequest $supportRequest)
    {
        $this->supportRequest = $supportRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS', "noreply@smartsuite.digitalpfizer.com"))
            ->view('emails.support_request');
    }
}
