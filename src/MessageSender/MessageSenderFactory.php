<?php

namespace App\MessageSender;

use vendor\SmsLibrary; // просто для примера
use vendor\TelegramApiClient;
use vendor\MailSender;

class MessageSenderFactory implements MessageSenderFactoryInterface {

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
        throw new \Exception('Недопустимы тип');
        break;
    };

    return $messageSender;
  }

  public static function checkType(string $type): bool {
    $allowed = [
      self::SMS,
      self::EMAIL,
      self::TELEGRAM
    ];

    if (in_array($type, $allowed, TRUE)) {
      return TRUE;
    }

    return FALSE;
  }

}