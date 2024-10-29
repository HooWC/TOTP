<?php

namespace App\Listeners;

use App\Mail\Register;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRegisterEmailNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 3;

    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        $email = new Register($event->user);
        Mail::to($event->user->email)->send($email);
    }

}
