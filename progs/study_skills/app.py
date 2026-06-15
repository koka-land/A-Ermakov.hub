from flask import Flask, render_template, request
from analyzer import analyze_csv
import os
import time

app = Flask(__name__)


# Автоматическое разрешение CORS для связи с PHP-сервером Hub
@app.after_request
def add_cors_headers(response):
    response.headers.add('Access-Control-Allow-Origin', '*')
    response.headers.add('Access-Control-Allow-Headers', 'Content-Type,Authorization')
    response.headers.add('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS')
    return response


STATS_DIR = 'files'
os.makedirs(STATS_DIR, exist_ok=True)


def increment_visits_with_cooldown():
    """Увеличивает счётчик визитов с тайм-аутом 30 минут для каждого IP"""
    visits_file = os.path.join(STATS_DIR, "visits.txt")
    ip_log_file = os.path.join(STATS_DIR, "ip_cooldowns.txt")

    # Получаем IP-адрес пользователя (учитываем проксирование хостинга)
    user_ip = request.headers.get('X-Forwarded-For', request.remote_addr)
    if user_ip and ',' in user_ip:
        user_ip = user_ip.split(',')[0].strip()

    current_time = int(time.time())
    cooldown_period = 30 * 60  # 30 минут в секундах

    # Читаем текущую базу IP-адресов и их тайм-аутов
    ip_database = {}
    if os.path.exists(ip_log_file):
        try:
            with open(ip_log_file, 'r', encoding='utf-8') as f:
                for line in f:
                    if ',' in line:
                        ip, ts = line.strip().split(',')
                        if current_time - int(ts) < cooldown_period:
                            ip_database[ip] = int(ts)
        except Exception:
            pass

    # Проверяем, заходил ли этот IP за последние 30 минут
    should_increment = False
    if user_ip not in ip_database:
        should_increment = True
        ip_database[user_ip] = current_time

    # Перезаписываем очищенный лог IP-адресов
    try:
        with open(ip_log_file, 'w', encoding='utf-8') as f:
            for ip, ts in ip_database.items():
                f.write(f"{ip},{ts}\n")
    except Exception:
        pass

    # Если тайм-аут пройден, увеличиваем основной счётчик visits.txt
    count = 0
    if os.path.exists(visits_file):
        try:
            with open(visits_file, 'r', encoding='utf-8') as f:
                count = int(f.read().strip())
        except ValueError:
            count = 0

    if should_increment:
        count += 1
        with open(visits_file, 'w', encoding='utf-8') as f:
            f.write(str(count))

    return count


def increment_uploads_counter():
    """Обычный счётчик для загруженных файлов (считаем каждую успешную загрузку)"""
    file_path = os.path.join(STATS_DIR, "uploads.txt")
    count = 0
    if os.path.exists(file_path):
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                count = int(f.read().strip())
        except ValueError:
            count = 0
    count += 1
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(str(count))
    return count


def get_counter_value(filename):
    file_path = os.path.join(STATS_DIR, filename)
    if os.path.exists(file_path):
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                return int(f.read().strip())
        except ValueError:
            return 0
    return 0


@app.route("/")
def index():
    visits_count = increment_visits_with_cooldown()
    uploads_count = get_counter_value("uploads.txt")
    return render_template("index.html", visits=visits_count, uploads=uploads_count)


@app.route("/analyze", methods=["POST"])
def analyze():
    try:
        file = request.files.get("csv_file")
        if not file:
            return "ERROR: no file received.", 400

        result = analyze_csv(file)

        uploads_count = increment_uploads_counter()
        visits_count = get_counter_value("visits.txt")

        result["global_stats"] = {
            "visits": visits_count,
            "uploads": uploads_count
        }

        return render_template("result.html", result=result)
    except Exception as e:
        return "ERROR: " + str(e), 500


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)