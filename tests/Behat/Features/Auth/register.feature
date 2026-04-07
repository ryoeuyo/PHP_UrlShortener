# language: ru

Функционал: Регистрация пользователя
    Предыстория:
        Допустим пользователя с email "email@example.com" не существует

    Сценарий: Успешная регистрация
        Когда я отправляю POST запрос на "/api/auth/register" с JSON:
        """
        {
            "email": "email@example.com",
            "password": "paSSword2222?"
        }
        """
        Тогда код ответа должен быть 200
        И ответ должен содержать поле "email" со значением "email@example.com"
        И ответ должен содержать поле "uuid" с валидным UUIDv4

    Сценарий: Неуспешная регистрация: Слабый пароль
        Когда я отправляю POST запрос на "/api/auth/register" с JSON:
        """
        {
            "email": "email@example.com",
            "password": "weak"
        }
        """
        Тогда код ответа должен быть 422
        И ответ должен содержать поле "message" со значением "Validation failed"

    Сценарий: Неуспешная регистрация: Неправильный формат email
        Когда я отправляю POST запрос на "/api/auth/register" с JSON:
        """
        {
            "email": "invalid@email",
            "password": "NormalPassword1234??"
        }
        """
        Тогда код ответа должен быть 422
        И ответ должен содержать поле "message" со значением "Validation failed"
