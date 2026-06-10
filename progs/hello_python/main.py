import sys
import json
import base64  # Добавили стандартный модуль для декодирования


def process_text(input_text):
    char_count = len(input_text)
    word_count = len(input_text.split())
    uppercase_text = input_text.upper()
    count_1 = sum(1 for i in input_text if i == '1')

    return {
        "original": input_text,
        "uppercase": uppercase_text,
        "stats": {
            "chars": char_count,
            "words": word_count,
            'one': count_1
        }
    }


def main():
    if len(sys.argv) < 2:
        print(json.dumps({"status": "error", "message": "Нет входных данных"}))
        return

    try:
        # 1. Забираем закодированную строку из аргументов
        base64_arg = sys.argv[1]

        # 2. Декодируем её обратно в нормальный JSON-текст
        json_bytes = base64.b64decode(base64_arg)
        json_str = json_bytes.decode('utf-8')

        # 3. Распаковываем JSON в словарь Python
        payload = json.loads(json_str)
        user_text = payload.get("text", "")

        # Запускаем нашу логику
        analysis = process_text(user_text)

        response = {
            "status": "success",
            "data": analysis
        }
        print(json.dumps(response, ensure_ascii=False))

    except Exception as e:
        print(json.dumps({"status": "error", "message": f"Ошибка Python: {str(e)}"}))


if __name__ == "__main__":
    main()