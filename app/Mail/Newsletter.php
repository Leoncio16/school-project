<?php

namespace App\Mail;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Newsletter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $name)
    {
      return $this->from('mail@example.com', 'Mailtrap')
          ->subject('Mailtrap Confirmation')
          ->markdown('mails.exmpl')
          ->with([
              'name' => 'użytkowniku',
              'link' => 'https://mailtrap.io/inboxes'
          ]);
    }
}
