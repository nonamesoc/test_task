<?php

namespace App\Model;

class UserSetting {

  protected int $id;

  protected int $uid;

  protected string $name;

  protected string $value;

  protected bool $confirmed;

  public function __construct(array $data) {
    foreach ($data as $property => $value) {
      $this->set($property, $value);
    };
  }

  public function set(string $name, mixed $value): void {
    $this->$name = $value;
  }

}