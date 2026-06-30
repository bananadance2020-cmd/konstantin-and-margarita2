<?php
$config_file = __DIR__ . '/vk_config.json';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['vk_user_id'])) {
        $vk_user_id = trim($_POST['vk_user_id']);
        
        // Читаем текущий конфиг
        $config_data = [];
        if (file_exists($config_file)) {
            $config_data = json_decode(file_get_contents($config_file), true);
        }
        
        // Обновляем ID
        $config_data['vk_user_id'] = $vk_user_id;
        
        // Сохраняем
        if (file_put_contents($config_file, json_encode($config_data, JSON_PRETTY_PRINT))) {
            $message = '<div class="success">✅ Настройки успешно сохранены! Теперь анкеты будут приходить вам ВКонтакте.</div>';
        } else {
            $message = '<div class="error">❌ Ошибка при сохранении настроек. Проверьте права на запись файла vk_config.json</div>';
        }
    }
}

// Получаем текущий ID для отображения в поле
$current_id = '';
if (file_exists($config_file)) {
    $config_data = json_decode(file_get_contents($config_file), true);
    if (isset($config_data['vk_user_id'])) {
        $current_id = htmlspecialchars($config_data['vk_user_id']);
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройка уведомлений ВКонтакте</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            margin-top: 0;
            color: #2787F5; /* Цвет VK */
            font-size: 24px;
            text-align: center;
            margin-bottom: 30px;
        }
        .step {
            margin-bottom: 25px;
            padding: 15px;
            background: #f9f9fc;
            border-radius: 8px;
            border-left: 4px solid #2787F5;
        }
        .step h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .btn-vk {
            display: inline-block;
            background: #2787F5;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            margin-top: 10px;
            transition: background 0.2s;
        }
        .btn-vk:hover {
            background: #1e6ec9;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            margin-bottom: 15px;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: #2787F5;
        }
        button[type="submit"] {
            background: #4caf50;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type="submit"]:hover {
            background: #43a047;
        }
        .success {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }
        .error {
            background: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Настройка анкет ВКонтакте</h1>
    
    <?= $message ?>

    <div class="step">
        <h3>Шаг 1: Узнайте свой ID</h3>
        <p>Чтобы анкеты приходили вам в личные сообщения, напишите нашему боту любое слово (например, "Привет"). Он моментально пришлет вам ваш ID.</p>
        <a href="https://vk.com/im?media=&sel=-239945231" target="_blank" class="btn-vk">Перейти к боту ВК</a>
    </div>

    <div class="step">
        <h3>Шаг 2: Вставьте ID сюда</h3>
        <form method="POST" action="">
            <label for="vk_user_id">Ваш личный ID ВКонтакте:</label>
            <input type="text" id="vk_user_id" name="vk_user_id" value="<?= $current_id ?>" placeholder="Например: 123456789" required>
            
            <button type="submit">Сохранить настройки</button>
        </form>
    </div>
    
    <div class="footer">
        После сохранения вы можете закрыть эту страницу.
    </div>
</div>

</body>
</html>
