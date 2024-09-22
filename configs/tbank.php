<?php

/**
 * Конфигурация для работы с TBank API.
 *
 * Этот файл используется для настройки параметров, необходимых для работы
 * с API TBank. Он содержит важную информацию, такую как текущая версия API
 * и URL-адреса конечных точек для тестовой и боевой сред. Используя эти параметры,
 * приложение сможет корректно взаимодействовать с системой TBank.
 */

use DFiks\TBank\Payments\Enums\TaxationType;

return [
    /*
    |--------------------------------------------------------------------------
    | Режим тестирования для внутренних проверок TBank
    |--------------------------------------------------------------------------
    |
    | Параметр 'testing_tbank' активирует режим тестирования, необходимый для
    | прохождения внутренних тестов в личном кабинете TBank. Этот режим позволяет
    | взаимодействовать с тестовыми терминалами, но при этом использовать
    | production API endpoints, чтобы симулировать реальные условия работы.
    |
    | - Значение по умолчанию можно установить через переменную окружения
    |   TESTING_TBANK.
    |
    | - Если 'testing_tbank' установлено в true, система будет использовать тестовые
    |   данные терминалов для выполнения внутренних проверок TBank, сохраняя
    |   взаимодействие с production API endpoints.
    |
    | Пример использования:
    | 'testing_tbank' => env('TESTING_TBANK', false),
    |
    */
    'testing_tbank' => env('TESTING_TBANK', false),

    /*
    |--------------------------------------------------------------------------
    | Режим отладки (Debug Mode)
    |--------------------------------------------------------------------------
    |
    | Этот параметр определяет, включен ли режим отладки для работы с API TBank.
    | В режиме отладки будут записываться дополнительные данные для анализа, такие как
    | запросы к API, ответы, и возможные ошибки. Это полезно при
    | разработке и тестировании интеграции с API.
    |
    | Когда `debug` включен, ваш пакет может выводить больше информации в
    | логах, помогая разработчикам обнаружить и исправить проблемы.
    |
    | Также в режиме отладки включена тестовая среда, поэтому можно не боятся, что
    | будет созданы лишние транзакции.
    |
    | Рекомендуется отключать режим отладки в рабочей среде (production), чтобы
    | не записывать лишние данные и не нарушать безопасность системы.
    |
    | Параметр может быть установлен через файл окружения `.env`. Если переменная
    | TBANK_DEBUG не указана, по умолчанию используется значение `true`.
    |
    | Пример в файле .env:
    | TBANK_DEBUG=false
    |
    */
    'debug' => env('TBANK_DEBUG', true),

    /*
    |--------------------------------------------------------------------------
    | Настройки магазина по умолчанию для TBank API
    |--------------------------------------------------------------------------
    |
    | Параметр 'default_shop' задает имя магазина по умолчанию, который будет
    | использоваться для взаимодействия с API TBank, если не указан конкретный
    | магазин в запросах. Имя магазина — это уникальный идентификатор, который
    | используется для обработки платежей и других операций через API.
    |
    | - Значение по умолчанию может быть установлено через переменную окружения
    |   TBANK_DEFAULT_SHOP.
    |
    | - Если вы не укажете переменную TBANK_DEFAULT_SHOP в файле .env, значение по
    |   умолчанию будет 'testing-shop', что обычно используется для тестирования
    |   и разработки.
    |
    | Пример использования:
    | 'default_shop' => env('TBANK_DEFAULT_SHOP', 'main'),
    |
    */
    'default_shop' => env('TBANK_DEFAULT_SHOP', 'main'),

    'generals' => [
        /*
        |--------------------------------------------------------------------------
        | Версия API TBank
        |--------------------------------------------------------------------------
        |
        | Этот параметр определяет, какую версию API будет использовать ваше
        | приложение для взаимодействия с TBank. Версия может изменяться при
        | обновлениях API, и вам нужно будет поддерживать актуальность этого значения.
        | Убедитесь, что ваше приложение и документация API TBank синхронизированы, чтобы
        | избежать проблем с несовместимостью версий.
        |
        | Пример: 'v1', 'v2', и т.д.
        |
        */
        'api_version' => env('TBANK_API_VERSION', 'v2'),

        /*
        |--------------------------------------------------------------------------
        | Конечные точки TBank API (Endpoints)
        |--------------------------------------------------------------------------
        |
        | Здесь вы можете указать URL-адреса для взаимодействия с API TBank.
        | Данный параметр включает два возможных URL: для тестовой среды и для
        | боевой среды (production).
        |
        | - test: URL для тестовой среды, которая используется для проверки и
        | отладки интеграции. Здесь можно выполнять запросы без рисков для
        | реальных данных. Рекомендуется использовать этот адрес при разработке
        | и тестировании системы.
        |
        | - production: URL для боевой среды, где выполняются реальные запросы
        | к системе TBank. Используйте этот адрес только после того, как вы
        | убедитесь, что интеграция работает корректно и готова к работе с реальными
        | данными.
        |
        | Убедитесь, что в вашем коде настроен правильный переключатель между
        | тестовой и боевой средой, чтобы избежать случайного отправления
        | реальных транзакций в тестовой среде.
        |
        */
        'endpoints' => [
            'test' => env('TBANK_ENDPOINT_TEST', 'https://rest-api-test.tinkoff.ru'),
            'production' => env('TBANK_ENDPOINT_PRODUCTION', 'https://securepay.tinkoff.ru'),
        ],

        /*
        |--------------------------------------------------------------------------
        | Настройки Webhook для TBank API
        |--------------------------------------------------------------------------
        |
        | Этот блок определяет настройки для обработки webhook запросов от TBank API.
        | Каждое поле настраивает важные параметры, такие как URL, методы и IP-адреса,
        | с которых разрешено отправлять запросы на конечную точку webhook.
        |
        */
        'webhook' => [
            /*
            |--------------------------------------------------------------------------
            | Обработчик Webhook для TBank API
            |--------------------------------------------------------------------------
            |
            | Поле 'handler' определяет, какой класс будет использоваться для обработки
            | входящих webhook запросов от TBank API. Этот класс должен реализовывать
            | интерфейс WebhookHandlerInterface и обеспечивать необходимую логику для
            | обработки данных, получаемых через webhook.
            |
            | - По умолчанию используется стандартный обработчик: \DFiks\TBank\Webhook\Handlers\DefaultWebhookHandler::class.
            |   Этот обработчик реализует базовую логику для работы с webhook.
            |
            | - Если вам требуется кастомная логика, вы можете указать свой обработчик, например:
            |   'handler' => \App\Handlers\CustomWebhookHandler::class,
            |
            | Пример использования:
            | 'handler' => \DFiks\TBank\Webhook\Handlers\DefaultWebhookHandler::class, // Использование стандартного обработчика
            | 'handler' => \App\Handlers\CustomWebhookHandler::class, // Использование Custom-обработчик
            |
            */
            'handler' => DFiks\TBank\Webhook\Handlers\DefaultWebhookHandler::class,
//            'handler' => \App\Handlers\CustomWebhookHandler::class, // Использование Custom-обработчик

            /*
            |--------------------------------------------------------------------------
            | URL для Webhook
            |--------------------------------------------------------------------------
            |
            | Это URL-адрес, на который будут отправляться уведомления (webhook) от TBank.
            | Ваша система будет обрабатывать эти запросы по данному маршруту.
            |
            | Пример: '/tbank/webhook'
            | Значение по умолчанию: '/tbank/webhook'
            |
            */
            'route_webhook_url' => env('TBANK_ROUTE_WEBHOOK_URL', '/tbank/webhook'),

            /*
            |--------------------------------------------------------------------------
            | Разрешённые HTTP-методы для Webhook
            |--------------------------------------------------------------------------
            |
            | Список HTTP-методов, которые разрешены для обработки запросов webhook.
            | Убедитесь, что вы указываете методы, которые безопасны и необходимы
            | для обработки данных (например, POST и GET).
            |
            | Пример: 'post,get'
            | Значение по умолчанию: 'get,post'
            |
            */
            'route_webhook_allowed_methods' => env('TBANK_ROUTE_WEBHOOK_ALLOWED_METHODS', 'get,post'),

            /*
            |--------------------------------------------------------------------------
            | Включение проверки IP-адресов
            |--------------------------------------------------------------------------
            |
            | Эта настройка позволяет включить или выключить проверку IP-адресов
            | для запросов, поступающих на webhook. Если значение false, проверка
            | IP-адресов не будет осуществляться.
            |
            | Значение по умолчанию: false
            |
            */
            'enabled_allowed_ip_addresses' => env('TBANK_ENABLED_ALLOWED_IP_ADDRESSES', false),

            /*
            |--------------------------------------------------------------------------
            | Разрешённые IP-адреса для Webhook
            |--------------------------------------------------------------------------
            |
            | Список IP-адресов и диапазонов, с которых разрешено отправлять
            | запросы на webhook. Это защитный механизм, позволяющий отклонить
            | запросы с недоверенных IP-адресов.
            |
            | Пример: ['91.194.226.0/23', '212.233.80.0/24']
            | Значение по умолчанию: IP-адреса TBank, а также локальный IP-адрес
            | для разработки, указанный в переменной среды TBANK_WEBHOOK_ALLOWED_LOCAL_IP_ADDRESS.
            |
            */
            'allowed_ip_addresses' => [
                '91.194.226.0/23',
                '91.218.132.0/24',
                '91.218.133.0/24',
                '91.218.134.0/24',
                '91.218.135.0/24',
                '212.233.80.0/24',
                '212.233.81.0/24',
                '212.233.82.0/24',
                '212.233.83.0/24',
                '91.194.226.181',
                // Локальный IP-адрес для разработки
                env('TBANK_WEBHOOK_ALLOWED_LOCAL_IP_ADDRESS'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Магазины юридического лица или ИП
    |--------------------------------------------------------------------------
    |
    | Данная секция позволяет настроить магазины, которые работают с системой TBank.
    | Здесь можно указать уникальные идентификаторы магазинов, URL-адреса и
    | информацию о терминалах для каждого магазина. Используйте переменные
    | окружения для того, чтобы легко переключаться между разными конфигурациями
    | в зависимости от среды (тестовая или боевая).
    |
    | Пример:
    | 'shops' => [
    |     'имя_магазина' => [
    |         'url' => 'https://магазин.рф',
    |         'identifiers' => [...],
    |         'terminals' => [...],
    |     ]
    | ]
    |
    */
    'shops' => [
        /*
        |--------------------------------------------------------------------------
        | Магазин по умолчанию (тестовый магазин)
        |--------------------------------------------------------------------------
        |
        | Этот магазин используется в качестве примера для разработки и тестирования.
        | Вы можете указать его идентификаторы и терминалы через переменные окружения.
        |
        | env('TBANK_SHOP_NAME', 'testing-shop') — позволяет динамически задавать имя
        | магазина через файл `.env`. Это имя будет использоваться для идентификации
        | магазина в системе.
        |
        */
        env('TBANK_SHOP_NAME', 'main') => [

            // URL-адрес магазина, по которому будет выполняться взаимодействие
            'url' => env('TBANK_SHOP_URL', 'https://tbank.ru'),

            /*
            |--------------------------------------------------------------------------
            | Идентификаторы магазина
            |--------------------------------------------------------------------------
            |
            | Здесь находятся идентификаторы, необходимые для идентификации
            | магазина в системе TBank. Каждый магазин должен иметь уникальные
            | идентификаторы, такие как merchant_name, merchant_id и terminal_id.
            |
            */
            'identifiers' => [
                // Название магазина, используемое в системе TBank
                'merchant_name' => env('TBANK_MERCHANT_NAME', 'test'),

                // Уникальный идентификатор магазина (ID) в системе TBank
                'merchant_id' => env('TBANK_MERCHANT_ID', 0),

                // Уникальный идентификатор терминала магазина
                'terminal_id' => env('TBANK_TERMINAL_ID', 0),
            ],

            /*
            |--------------------------------------------------------------------------
            | Терминалы магазина
            |--------------------------------------------------------------------------
            |
            | Секция терминалов содержит информацию о тестовых и боевых терминалах.
            | В зависимости от того, в какой среде (тестовой или боевой) вы работаете,
            | выбирайте соответствующий терминал. Каждый терминал должен иметь
            | уникальный идентификатор (terminal_id) и пароль для аутентификации.
            |
            */
            'terminals' => [

                /*
                |--------------------------------------------------------------------------
                | Тестовый терминал
                |--------------------------------------------------------------------------
                |
                | Этот терминал используется для проведения тестовых транзакций.
                | Его данные (ID и пароль) задаются через переменные окружения, чтобы
                | избежать хранения чувствительных данных в коде.
                |
                */
                'test' => [
                    // Уникальный ID тестового терминала
                    'terminal_id' => env('TBANK_TERMINAL_TEST', 'test'),

                    // Пароль для тестового терминала
                    'password' => env('TBANK_TERMINAL_PASSWORD', 'test'),

                    // Включить уведомления по HTTP
                    'http_notification' => env('TBANK_TERMINAL_TEST_HTTP_NOTIFICATION', false),

                    // Страница успеха
                    'success_url' => env('TBANK_TERMINAL_TEST_SUCCESS_URL', false),

                    // Страница ошибки
                    'error_url' => env('TBANK_TERMINAL_TEST_ERROR_URL', false),

                    // Система налогообложения
                    'taxation' => env('TBANK_TERMINAL_TEST_TAXATION', TaxationType::UsnIncome->value),
                ],

                /*
                |--------------------------------------------------------------------------
                | Боевой терминал
                |--------------------------------------------------------------------------
                |
                | Этот терминал используется для проведения реальных транзакций.
                | Необходимо убедиться, что данные этого терминала корректны и защищены.
                |
                */
                'production' => [
                    // Уникальный ID боевого терминала
                    'terminal_id' => env('TBANK_TERMINAL_PRODUCTION', 'production'),

                    // Пароль для боевого терминала
                    'password' => env('TBANK_TERMINAL_PRODUCTION_PASSWORD', 'production'),

                    // Включить уведомления по HTTP
                    'http_notification' => env('TBANK_TERMINAL_PRODUCTION_HTTP_NOTIFICATION', false),

                    // Страница успеха
                    'success_url' => env('TBANK_TERMINAL_PRODUCTION_SUCCESS_URL', false),

                    // Страница ошибки
                    'error_url' => env('TBANK_TERMINAL_PRODUCTION_ERROR_URL', false),

                    // Система налогообложения
                    'taxation' => env('TBANK_TERMINAL_TEST_TAXATION', TaxationType::UsnIncome->value),
                ],
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Дополнительные магазины
        |--------------------------------------------------------------------------
        |
        | Здесь вы можете добавить информацию о других магазинах, если у вас есть
        | несколько точек продаж или подразделений. Просто скопируйте структуру
        | магазина и измените параметры под свои нужды.
        |
        */

        // Пример:
        // 'my_second_shop' => [
        //     'url' => 'https://secondshop.com',
        //     'identifiers' => [...],
        //     'terminals' => [...],
        // ]
    ],
];
