<?php

// Данные вашего центрального бота (настройте их после создания группы)
$confirmation_token = 'ВАШ_КОД_ПОДТВЕРЖДЕНИЯ'; // Строка, которую нужно вернуть серверу ВК
$vk_token = 'ВАШ_ЦЕНТРАЛЬНЫЙ_ТОКЕН';         // Токен группы для отправки сообщений

// Получаем и декодируем JSON-данные от ВКонтакте
$data = json_decode(file_get_contents('php://input'));

// Проверяем, что данные получены
if (!$data) {
    echo "This is a VK Bot Webhook endpoint.";
    exit;
}

// Проверяем тип события
switch ($data->type) {
    
    // Подтверждение адреса сервера
    case 'confirmation':
        echo $confirmation_token;
        break;
        
    // Получение нового сообщения
    case 'message_new':
        // Извлекаем ID пользователя, который написал боту
        $user_id = $data->object->message->from_id;
        
        // Формируем текст ответа
        $message_text = "Привет! 👋\n\nТвой личный ID ВКонтакте: {$user_id}\n\nСкопируй эти цифры и вставь их в настройки анкеты на сайте. После этого все заявки будут приходить прямо в этот диалог!";
        
        // Отправляем сообщение обратно пользователю
        $request_params = array(
            'message' => $message_text,
            'peer_id' => $user_id,
            'access_token' => $vk_token,
            'v' => '5.131',
            'random_id' => mt_rand() // Уникальный идентификатор для защиты от дублей
        );
        
        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
        
        // Возвращаем "ok", чтобы сервер ВКонтакте понял, что сообщение обработано
        echo 'ok';
        break;
        
    default:
        // Для всех остальных событий просто возвращаем "ok"
        echo 'ok';
        break;
}

?>
