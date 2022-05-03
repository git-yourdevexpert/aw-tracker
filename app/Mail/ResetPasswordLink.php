<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordLink extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The reset password token instance.
     *
     * @var \App\Models\User
     */
    private $record;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($record)
    {
        $this->record = $record;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.reset_password')
                    ->subject('Reset Your Password')
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->with(['record' => $this->record]);
    }
}
