<?php


namespace App\Controller;

use App\Service\ConfirmationCodeService;
use App\MessageSender\MessageSenderFactory;
use App\Model\User;
use App\Service\UserSettingsStorageInterface;
use vendor\Request; // Какой-нибудь класс Request
use vendor\Response; // Какой-нибудь класс Response

class UserSettingsController {

  protected ConfirmationCodeService $confirmationCodeService;

  protected UserSettingsStorageInterface $userSettingsStorage;

  public function __construct(ConfirmationCodeService $confirmationService, UserSettingsStorageInterface $userSettingsStorage) {
    $this->confirmationCodeService = $confirmationService;
    $this->userSettingsStorage = $userSettingsStorage;
  }

  public function updateSettings(Request $request, User $user): Response {
    $requiredInputs = [
      'name',
      'value',
    ];

    foreach ($requiredInputs as $input_name) {
      $requiredInputs[$input_name] = $request->get($input_name);

      // Проверяем есть ли значения
      if (empty($requiredInputs[$input_name])) {
        throw new \Exception("Нет параметра {$input_name}");
      }
    }

    $sender_type = $request->session()->get('sender_type') ?? $request->get('sender_type');
    $this->checkSenderType($sender_type);
    // Записываем выбранный тип в сессию
    $request->session()->set('sender_type', $sender_type);

    $this->userSettingsStorage->updateSettingsByUser($user, $requiredInputs['name'], $requiredInputs['value']);

    $code = $this->confirmationCodeService->generateCode($user);

    $message = $code . ' Код подтверждения смены настройки';
    $messageSender = MessageSenderFactory::create($sender_type);
    $messageSender->sendMessage($user, $message);

    return new Response('Вам отправлен код подтверждения');
  }

  public function confirmUpdate(Request $request, User $user): Response {
    $requiredInputs = [
      'code',
      'name',
    ];
    foreach ($requiredInputs as $input_name) {
      $requiredInputs[$input_name] = $request->get($input_name);

      if (empty($requiredInputs[$input_name])) {
        throw new \Exception("Нет {$input_name}");
      }
    }

    $is_confirmed = $this->confirmationCodeService->checkCode($user, $requiredInputs['code']);

    $message = '';
    if ($is_confirmed) {
      $this->userSettingsStorage->confirmUpdateSetting($user, $requiredInputs['name']);
      $message = 'Обновление прошло успешно';
    } else {
      $message = 'Неверный код';
    }

    return new Response($message);
  }

  protected function checkSenderType(string $sender_type): void {
    if (empty($sender_type)) {
      throw new \Exception("Нужно выбрать способ отправки");
    }

    if (!MessageSenderFactory::checkType($sender_type)) {
      throw new \Exception('Недопустимый тип');
    }
  }

}