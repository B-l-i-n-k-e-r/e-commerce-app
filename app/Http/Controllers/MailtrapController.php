<?php

namespace App\Http\Controllers;

use App\Services\MailtrapService;

class MailtrapController extends Controller
{
    protected $mailtrap;

    public function __construct(MailtrapService $mailtrap)
    {
        $this->mailtrap = $mailtrap;
    }

    public function inbox()
{
    $messages = $this->mailtrap->fetchInboxMessages();

    // Ensure $messages is always an array (empty if no messages)
    if (!is_array($messages)) {
        $messages = [];
    }

    return view('mailtrap.inbox', compact('messages'));
}


}
