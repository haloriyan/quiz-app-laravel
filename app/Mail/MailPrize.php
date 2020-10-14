<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailPrize extends Mailable
{
    use Queueable, SerializesModels;

    public $name,$prizeName,$fromEmail,$fromName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->prizeName = $data['prizeName'];
        $this->fromEmail = $data['from']['email'];
        $this->fromName = $data['from']['name'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromEmail, $this->fromName)
        ->subject('You are won DAILY PRIZE!!')
        ->view('email.dailyPrize')
        ->with([
            'name' => $this->name,
            'prizeName' => $this->prizeName
        ]);
    }
}
