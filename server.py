import http.server
import socketserver

PORT = 8000


class PHPAsHTMLHandler(http.server.SimpleHTTPRequestHandler):
    def do_GET(self):
        # Если запрашивают главную или index.php, подменяем заголовки
        if self.path == '/' or self.path == '/index.php':
            self.path = '/index.php'
            self.send_response(200)
            self.send_header('Content-type', 'text/html; charset=utf-8')
            self.end_headers()
            with open('index.php', 'rb') as file:
                self.wfile.write(file.read())
            return

        # Все остальные файлы (css, js) отдаем как обычно
        return super().do_GET()


with socketserver.TCPServer(("", PORT), PHPAsHTMLHandler) as httpd:
    print(f"Сервер запущен! Кликни сюда: http://localhost:{PORT}/")
    try:
        httpd.serve_forever()
    except KeyboardInterrupt:
        print("\nСервер остановлен.")