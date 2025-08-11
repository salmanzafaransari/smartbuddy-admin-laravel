<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountDeletionCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $user;

    public function __construct($code, $user)
    {
        $this->code = $code;
        $this->user = $user;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Account Deletion Verification Code',
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'emails.account_deletion_code',
            with: [
                'code' => $this->code,
                'user' => $this->user
            ]
        );
    }

    public function attachments()
    {
        return [];
    }
}
