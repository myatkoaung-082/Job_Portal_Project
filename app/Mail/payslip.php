<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class payslip extends Mailable
{
    use Queueable, SerializesModels;

    public $companyEmail;
    public $companyName;
    public $expireDate;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($companyEmail,$companyName,$expireDate)
    {
        // $this->get_user_email = $get_user_email;
        $this->companyEmail = $companyEmail;
        $this->companyName = $companyName;
        $this->expireDate = $expireDate;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Payslip',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'otpmail.payslip',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
