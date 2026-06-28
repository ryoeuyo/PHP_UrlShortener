# language: ru

Функционал: Создание короткой ссылки
    Предыстория:
        Допустим пользователя с email "emailTest@example.com" не существует
        И существует пользователь с email "emailTest@example.com" и паролем "testPass1234?"
        И я авторизован как пользователь с email "emailTest@example.com" и паролем "testPass1234?"

    Сценарий: Успешное создание возвращает готовую короткую ссылку
        Когда я отправляю POST запрос на "/api/shorten" с JSON:
        """
        {
            "url": "https://youtube.com",
            "ttlSeconds": 3600
        }
        """
        Тогда код ответа должен быть 201
        И ответ должен содержать поле "url"
        И поле "url" в ответе должно быть готовой короткой ссылкой

    Сценарий: Создание в пределах лимита
        Допустим я создал короткую ссылку для "https://example.com"
        И я создал короткую ссылку для "https://example.com"
        И я создал короткую ссылку для "https://example.com"
        И я создал короткую ссылку для "https://example.com"
        Когда я отправляю POST запрос на "/api/shorten" с JSON:
        """
        {
            "url": "https://youtube.com",
            "ttlSeconds": 3600
        }
        """
        Тогда код ответа должен быть 201
        И ответ должен содержать поле "url"

    Сценарий: Превышение лимита коротких ссылок
        Допустим я создал короткую ссылку для "https://example.com"
        И я создал короткую ссылку для "https://example.com"
        И я создал короткую ссылку для "https://example.com"
        И я создал короткую ссылку для "https://example.com"
        И я создал короткую ссылку для "https://example.com"
        Когда я отправляю POST запрос на "/api/shorten" с JSON:
        """
        {
            "url": "https://youtube.com",
            "ttlSeconds": 3600
        }
        """
        Тогда код ответа должен быть 400
        И ответ должен содержать поле "message" со значением "User exceeded the maximum number of shorten urls allowed"
