import sys
import json


def main():
    # 1. Получаем данные от PHP (они придут аргументом командной строки)
    try:
        input_data = json.loads(sys.argv[1]) if len(sys.argv) > 1 else {}
    except Exception as e:
        print(json.dumps({"status": "error", "message": "Неверный формат входных данных"}))
        return

    # 2. Вытаскиваем параметры
    user_name = input_data.get("name", "Незнакомец")

    # === ЗДЕСЬ БУДЕТ ЛОГИКА ТВОЕГО ОТЧЁТА ===
    # Например, чтение CSV, сложная математика, обработка логов и т.д.
    result_message = f"Привет, {user_name}! Python успешно обработал твой запрос."
    calculated_value = 42
    # ========================================

    # 3. Формируем ответ для PHP
    response = {
        "status": "success",
        "message": result_message,
        "data": {
            "magic_number": calculated_value
        }
    }

    # 4. Выплёвываем JSON обратно (PHP его поймает)
    print(json.dumps(response, ensure_ascii=False))


if __name__ == "__main__":
    main()