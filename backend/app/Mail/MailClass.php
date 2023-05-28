<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailClass extends Mailable
{
    use Queueable, SerializesModels;


    public $term;
    public $template;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($term, $template, $subject)
    {
        $this->term = $term;
        $this->template = $template;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pretty_date = date("d.m.Y", strtotime($this->term->date));
        $pretty_time = day_of_week($this->term->full_time) . ", ".  $pretty_date . " ob " . $this->term->time;
        $type_name = $this->term->service_type->name;
        $type_price = $this->term->service_type->price;
        $admin_name = admin()->name;
        return $this->view('emails.' . $this->template)
            ->with([
                "admin_name" => $admin_name,
                "name" => $this->term->name,
                "pretty_time" => $pretty_time,
                "type_name" => $type_name,
                "type_price" => $type_price,
                "contact" => $this->term->contact])
            ->subject($this->subject)
            ->from(admin()->email, admin()->name);
        
    }
}
