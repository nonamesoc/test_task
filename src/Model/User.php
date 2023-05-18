<?php

namespace App\Model;

class User {

  protected int $id;

  protected string $name;

  protected string $email;

  protected string $phone;

  protected int $telegram_id;

  public function getId(): int {
    return $this->id;
  }

  public function getEmail(): string {
    return $this->email;
  }

  public function getPhone(): string {
    return $this->phone;
  }

  public function getTelegramId(): string {
    return $this->telegram_id;
  }

}