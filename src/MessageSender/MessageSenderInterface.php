<?php

namespace App\MessageSender;

use App\Model\User;

interface MessageSenderInterface {

  public function sendMessage(User $user, string $text): void;

}