<?php

namespace App\App\Services;
class NewsLetterManager
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

}