<?php

namespace App\MessageSender;

use vendor\SmsLibrary; // просто для примера
use vendor\TelegramApiClient;
use vendor\MailSender;

class MessageSenderFactory {

  const SMS = 'sms';
  const EMAIL = 'email';
  const TELEGRAM = 'telegram';

  public static function create(string $type): MessageSenderInterface {
    $messageSender = NULL;
    switch ($type) {
      case self::SMS:
        $messageSender = new SmsMessageSender(new SmsLibrary());
        break;
      case self::EMAIL:
        $messageSender = new EmailMessageSender(new MailSender());
        break;
      case self::TELEGRAM:
        $messageSender = new TelegramMessageSender(new TelegramApiClient());
        break;
      default:
        // @todo Exception
        break;
    };

    return $messageSender;
  }

}