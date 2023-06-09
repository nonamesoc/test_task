<?php

namespace App\Service;

use App\Model\User;

class ConfirmationCodeService implements ConfirmationCodeServiceInterface {

  public function generateCode(User $user, int $digits = 4): string {
    $i = 0;
    $pin = "";
    while($i < $digits){
      $pin .= mt_rand(0, 9);
      $i++;
    }

    $this->saveCode($pin, $user);

    return $pin;
  }

  protected function saveCode(string $code, User $user): void {
    // Сохраняет код по user id ($user->getId()) в таблицу confirmation_codes
    // либо в redis или в сессию
  }

  public function checkCode(string $code, User $user): bool {
    $user_id = $user->getId();
    // Здесь должно быть получение кода по user id из базы данных
    $exist_code = '';
    if ($code === $exist_code) {
      return TRUE;
    }

    return FALSE;
  }

}