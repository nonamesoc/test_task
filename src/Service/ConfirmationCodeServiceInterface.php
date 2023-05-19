<?php

namespace App\Service;

use App\Model\User;

interface ConfirmationCodeServiceInterface {

  public function generateCode(User $user, int $digits): string;

  public function checkCode(string $code, User $user): bool;

}