<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductOrderShippingEmail extends Mailable
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
        $data['data']=  $this->data;
        // dd($data['data']);

        $subject=env('APP_NAME')." - Product Order";
        // return $this->view('email.product_order_shipping', $data)
        return $this->view('email.order', $data)
        ->to($data['data']['data']->shipping_email)
        ->subject($subject)
        ->from(env('MAIL_USERNAME'),env('APP_NAME'));
    }
}
