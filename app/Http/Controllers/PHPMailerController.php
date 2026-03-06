<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomMailService;

class PHPMailerController extends Controller
{
    protected $mailService;

    public function __construct(CustomMailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function testMail()
    {
        $response = $this->mailService->sendPHPMail(
            'recipient@example.com', 
            'Hello from PHPMailer!', 
            '<h1>It Works!</h1><p>This email was sent using PHPMailer in Laravel.</p>'
        );

        if ($response === true) {
            return "Email sent successfully!";
        } else {
            return $response;
        }
    }
}