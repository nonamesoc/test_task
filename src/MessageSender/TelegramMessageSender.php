<?php

namespace App\MessageSender;

use App\Model\User;
use vendor\TelegramApiClient; // просто для примера

class TelegramMessageSender implements MessageSenderInterface {

  protected TelegramApiClient $telegramClient;

  public function __construct(TelegramApiClient $telegramClient) {
    $this->telegramClient = $telegramClient;
  }

  public function sendMessage(User $user, string $text): void {
    $this->telegramClient->sentMessage($user->getTelegramId(), $text);
  }

}