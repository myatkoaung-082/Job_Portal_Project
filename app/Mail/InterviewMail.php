<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InterviewMail extends Mailable
{
    use Queueable, SerializesModels;
    public $seekerEmail;
    public $seekerName;
    public $time;
    public $date;
    public $location;
    public $companyName;
    public $industryName;
    public $jobPosition;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($seekerEmail, $seekerName, $time, $date, $location, $jobPosition, $industryName, $companyName,)
    {
        //
        $this->seekerEmail = $seekerEmail;
        $this->seekerName = $seekerName;
        $this->time = $time;
        $this->date = $date;
        $this->location = $location;
        $this->companyName = $companyName;
        $this->industryName = $industryName;
        $this->jobPosition = $jobPosition;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Interview Mail',
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
            view: 'otpmail.interview_mail',
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
