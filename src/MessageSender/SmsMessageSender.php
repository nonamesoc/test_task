<?php

namespace App\MessageSender;

use App\Model\User;
use vendor\SmsLibrary; // просто для примера

class SmsMessageSender implements MessageSenderInterface {

  protected SmsLibrary $smsLibrary;

  public function __construct(SmsLibrary $smsLibrary) {
    $this->smsLibrary = $smsLibrary;
  }

  public function sendMessage(User $user, string $text): void {
    $this->smsLibrary->sentMessage($user->getPhone(), $text);
  }

}