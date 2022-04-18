<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\NewReservation;
use Carbon\Carbon;

if (!function_exists('send_mail_new_reservation')){
    function send_mail_new_reservation($term) {
        $to_name = "Urban Fujan";
        $to_email = "gal.irt.01@gmail.com";
        $pretty_time = day_of_week($term->full_time) . ", ".  $term->date . " ob " . $term->time;
        $type_name = $term->service_type->name;
        $data = array("name" => $term->name, "pretty_time" => $pretty_time, "type_name" => $type_name);
        Mail::send('emails.confirm', $data, function($message) use ($to_name, $to_email, $term) {
        $message->to($to_email, $to_name)
        ->subject("Nova rezervacija - " . $term->name);
        });
    }

}

if (!function_exists('day_of_week')){
    function day_of_week($date) {
        $weekMap = [
            0 => 'Ned',
            1 => 'Pon',
            2 => 'Tor',
            3 => 'Sre',
            4 => 'Čet',
            5 => 'Pet',
            6 => 'Sob',
        ];
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        return $weekMap[$dayOfWeek];
    }

}