<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\MailClass;
use Carbon\Carbon;
use App\Models\User;

if (!function_exists('admin')){
    function admin() {
        $admin_slug = request()->route('admin_slug');
        return User::where("slug", $admin_slug)->first();
    }
}

if (!function_exists('send_mail_new_reservation')){
    function send_mail_new_reservation($term) {
        $subject = "Nova rezervacija - " . $term->name;
        Mail::to("urban.fujan2@gmail.com")->queue(new MailClass($term, "new_reservation", $subject));
    }
}

if (!function_exists('send_mail_confirmation')){
    function send_mail_confirmation($term) {
        if (is_valid_email($term->contact)) {
            $subject = "Potrditev rezervacije - " . $term->service_type->name;
            Mail::to($term->contact)->queue(new MailClass($term, "reservation_confirm", $subject));
        }
    }
}

if (!function_exists('send_mail_cancellation')){
    function send_mail_cancellation($term) {
        if (is_valid_email($term->contact)) {
            $subject = "Preklic rezervacije - " . $term->service_type->name;
            Mail::to($term->contact)->queue(new MailClass($term, "reservation_cancel", $subject));
        }
    }
}

if (!function_exists('is_valid_email')){
    function is_valid_email($email) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
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