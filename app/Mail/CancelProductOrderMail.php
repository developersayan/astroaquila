<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelProductOrderMail extends Mailable
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

        $subject=env('APP_NAME')." - Order Cancelled - ".$this->data['data']['order_id'];
        // return $this->view('email.product_order', $data)
		if($data['data']['data']->customer->email!=$data['data']['data']->shipping_email)
		{
			return $this->view('email.cancel_product_order', $data)
			->to([$data['data']['data']->customer->email,$data['data']['data']->shipping_email])
			// ->to('soumojit.sad@gmail.com')
			->subject($subject)
			->from(env('MAIL_USERNAME'),env('APP_NAME'));
		}
		else
		{
			return $this->view('email.cancel_product_order', $data)
			->to($data['data']['data']->customer->email)
			// ->to('soumojit.sad@gmail.com')
			->subject($subject)
			->from(env('MAIL_USERNAME'),env('APP_NAME'));
		}
        
    }
}
