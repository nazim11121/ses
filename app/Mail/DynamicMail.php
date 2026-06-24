<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DynamicMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $bodyContent;

    public function __construct(string $subject, string $body)
    {
        $this->subject = $subject;
        $this->bodyContent = $body;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('mail.dynamic');
    }
}
