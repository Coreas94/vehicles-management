<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ResponseMail extends Mailable
{
    use Queueable, SerializesModels;
    public $response;


    /**
     * Create a new message instance.
     */
    public function __construct($response)
    {
        $this->response = (string) $response;
    }

    public function build()
    {
        return $this->subject('Resultado de la Importación')
                    ->view('emails.result_import')
                    ->with(['response' => $this->response]);
    }
}
