# language: ru

Функционал: Авторизвация пользователя
    Предыстория:
        Допустим пользователя с email "email@example.com" не существует

    Сценарий: Успешный вход
        Допустим существует пользователь с email "email@example.com" и паролем "tEst11234?"
        Тогда я отправляю POST запрос на "api/auth/login" с JSON:
        """
        {
            "email": "email@example.com",
            "password": "tEst11234?"
        }
        """
        Тогда код ответа должен быть 200
        И ответ должен содержать поле "accessToken"

    Сценарий: Не успешный вход: пользователь не существует
        Когда я отправляю POST запрос на "api/auth/login" с JSON:
        """
        {
            "email": "email@example.com",
            "password": "tEst11234?"
        }
        """
        Тогда код ответа должен быть 404
        И ответ должен содержать поле "message" со значением "User not found"

    Сценарий: Не успешный вход: неверный пароль
        Допустим существует пользователь с email "email@example.com" и паролем "tEst11234?"
        Тогда я отправляю POST запрос на "api/auth/login" с JSON:
        """
        {
            "email": "email@example.com",
            "password": "tEst11234_11?"
        }
        """
        Тогда код ответа должен быть 400
        И ответ должен содержать поле "message" со значением "Invalid credentials"
