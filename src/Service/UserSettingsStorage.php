<?php

namespace App\Service;

use App\Model\User;
use App\Model\UserSetting;

class UserSettingsStorage implements UserSettingsStorageInterface {

  public function create(array $data): UserSetting {
    if (!isset($data['confirmed'])) {
      // Создаём по умолчанию неподтверждённую настройку
      $data['confirmed'] = FALSE;
    }

    return new UserSetting($data);
  }

  public function save(UserSetting $settings): UserSetting {
    //сохранение в базу данных

    return $settings;
  }

  public function updateSettingsByUser(User $user, string $name, mixed $value): void {
    $userSetting = $this->findByUserAndSettingName($user, $name);
    if (empty($userSetting)) {
      $userSetting = $this->create([
        'uid' => $user->getId(),
        'name' => $name,
        'value' => $value,
      ]);
    }

    $userSetting->set($name, $value);
    $this->save($userSetting);
  }

  public function confirmUpdateSetting(User $user, string $name): void {
    $userSetting = $this->findByUserAndSettingName($user, $name);
    $userSetting->set('confirmed', TRUE);
    $this->save($userSetting);
  }

  protected function findByUserAndSettingName(User $user, string $name): ?UserSetting {
    // Ищем в базе настройку по юзер id и имени настройки, если не находим то возращаем NULL
  }

}