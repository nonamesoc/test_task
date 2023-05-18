<?php

namespace App\MessageSender;

use App\Model\User;
use vendor\MailSender; // просто для примера

class EmailMessageSender implements MessageSenderInterface {

  protected MailSender $mailSender;

  public function __construct(MailSender $mailSender) {
    $this->mailSender = $mailSender;
  }

  public function sendMessage(User $user, string $text): void {
    $this->mailSender->sentMessage($user->getEmail(), $text);
  }

}