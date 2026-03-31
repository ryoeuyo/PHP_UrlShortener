# language: ru
Функционал: Регистрация пользователя
    Сценарий: Успешная регистрация
        Когда я отправляю POST запрос на "api/register" с JSON:
        """
        {
            "email": "email@example.com",
            "password": "test_password"
        }
        """
        Тогда код ответа должен быть 200
        И ответ должен содержать поле "email" со значением "email@example.com"
        И ответ должен содержать поле "uuid" с валидным UUIDv4
