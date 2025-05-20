<?php

// Список криптовалютных пар
$symbols = ["TRXUSDT", "BTCUSDT", "ETHUSDT", "BNBUSDT", "ADAUSDT"];

// Функция для получения цены через API Binance
function getPrice($symbol) {
    // URL API Binance
    $url = "https://api.binance.com/api/v3/ticker/price?symbol=" . $symbol;

    // Инициализация cURL
    $ch = curl_init();

    // Настройка параметров cURL
    curl_setopt($ch, CURLOPT_URL, $url);            // Адрес запроса
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);     // Возврат результата как строки
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);           // Таймаут

    // Выполнение запроса
    $response = curl_exec($ch);

    // Проверка на ошибку
    if (curl_errno($ch)) {
        echo 'Ошибка cURL: ' . curl_error($ch);
    }

    // Закрытие cURL
    curl_close($ch);

    // Обработка JSON-ответа
    $data = json_decode($response, true);

    // Возврат цены или ошибки
    if (isset($data['price'])) {
        return $data['price'];
    } else {
        return "Ошибка получения данных";
    }
}

// Цикл по всем валютным парам
foreach ($symbols as $symbol) {
    $price = getPrice($symbol);
    echo "Цена {$symbol}: {$price} USD<br>";
}

?>
