<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCustomer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['data'] =  $this->data;
        //dump($this->request);
        $subject=env('APP_NAME')." - Puja Link And Note";
        
        return $this->view('email.notify_customer', $data)
                     ->to($this->data['email'])
                     ->subject($subject)
                     ->from(env('MAIL_USERNAME'),env('APP_NAME'));
    }
}
