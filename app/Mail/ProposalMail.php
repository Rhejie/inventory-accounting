<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProposalMail extends Mailable
{
    use Queueable, SerializesModels;
    private $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $details = $this->details;
        $img_url = env('APP_URL')."/img/logo.png";
        $url = env('APP_URL')."/";
        $file_url = $url."/storage".$this->details->file;
        return $this->markdown('emails.proposal')
            ->with(['details' => $details, 'img_url' => $img_url, 'url' => $url])
            ->attach($file_url, [
                'as' => $this->details->info->proposal_number.'.pdf',
                'mime' => 'application/pdf'
            ]);
    }
}
