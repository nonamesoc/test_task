<?php

namespace App\MessageSender;

interface MessageSenderFactoryInterface {

  public static function create(string $type): MessageSenderInterface;

  public static function checkType(string $type): bool;

}