<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $data, $layout, $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($layout, $subject = "", $data = [])
    {
        //
        $this->layout = $layout;
        $this->data = $data;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view($this->layout);
    }
}
