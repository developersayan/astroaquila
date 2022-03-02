<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductOrderEmail extends Mailable
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
		if(@$this->data['type']=='H')
		{
			$subject=env('APP_NAME')." - Horoscope Order";
			// return $this->view('email.product_order', $data)
			return $this->view('email.order', $data)
			->to($this->data['email'])
			// ->to('soumojit.sad@gmail.com')
			->subject($subject)
			->from(env('MAIL_USERNAME'),env('APP_NAME'));
		}
		else
		{
			$subject=env('APP_NAME')." - Product Order";
			// return $this->view('email.product_order', $data)
			return $this->view('email.order', $data)
			->to($data['data']['data']->customer->email)
			// ->to('soumojit.sad@gmail.com')
			->subject($subject)
			->from(env('MAIL_USERNAME'),env('APP_NAME'));
		}
        
    }
}
