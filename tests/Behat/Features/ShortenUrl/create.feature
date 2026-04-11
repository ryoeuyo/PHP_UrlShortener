# language: ru

Функционал: Создание короткой ссылки
    Предыстория:
        Допустим существует пользователь с email "emailTest@example.com" и паролем "testPass1234?"
        И я авторизован как пользователь с email "emailTest@example.com" и паролем "testPass1234?"

    Сценарий: Успешное создание
        Когда я отправляю POST запрос на "/api/shorten" с JSON:
        """
        {
            "url": "https://youtube.com",
            "ttlSeconds": 3600
        }
        """
        Тогда код ответа должен быть 201
        И ответ должен содержать поле "originalUrl" со значением "https://youtube.com"
