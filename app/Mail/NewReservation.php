<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewReservation extends Mailable
{
    use Queueable, SerializesModels;


    public $term;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($term)
    {
        $this->term = $term;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pretty_time = day_of_week($this->term->full_time) . ", ".  $this->term->date . " ob " . $this->term->time;
        $type_name = $this->term->service_type->name;
        return $this->view('emails.new_reservation')
            ->with(["name" => $this->term->name, "pretty_time" => $pretty_time, "type_name" => $type_name, "contact" => $this->term->contact])
            ->subject("Nova rezervacija - " . $this->term->name)
            ->from(env("MAIL_USERNAME", "narocanje.webapp@mail.com"), env('MAIL_TO_NAME'));
        
    }
}
