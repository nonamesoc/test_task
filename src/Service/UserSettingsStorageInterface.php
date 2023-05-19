<?php

namespace App\Service;

use App\Model\User;
use App\Model\UserSetting;

interface UserSettingsStorageInterface {

  public function create(array $data): UserSetting;

  public function save(UserSetting $settings): UserSetting;

  public function updateSettingsByUser(User $user, string $name, mixed $value): void;

  public function confirmUpdateSetting(User $user, string $name): void;

}