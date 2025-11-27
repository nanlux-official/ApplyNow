<?php
class Router {
    private $routes = [];
    
    public function get($path, $callback) {
        $this->addRoute('GET', $path, $callback);
    }
    
    public function post($path, $callback) {
        $this->addRoute('POST', $path, $callback);
    }
    
    private function addRoute($method, $path, $callback) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }
    
    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Loại bỏ base path nếu có
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptName !== '/') {
            $requestUri = str_replace($scriptName, '', $requestUri);
        }
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod) {
                $pattern = $this->convertToRegex($route['path']);
                
                if (preg_match($pattern, $requestUri, $matches)) {
                    array_shift($matches); // Bỏ match đầu tiên
                    
                    // Lọc chỉ lấy numeric keys (bỏ named captures)
                    $params = array_filter($matches, function($key) {
                        return is_int($key);
                    }, ARRAY_FILTER_USE_KEY);
                    $params = array_values($params); // Re-index array
                    
                    $callback = $route['callback'];
                    
                    if (is_array($callback)) {
                        $controller = new $callback[0]();
                        $method = $callback[1];
                        return call_user_func_array([$controller, $method], $params);
                    } else {
                        return call_user_func_array($callback, $params);
                    }
                }
            }
        }
        
        // 404 Not Found
        http_response_code(404);
        echo "404 - Trang không tồn tại";
    }
    
    private function convertToRegex($path) {
        // Chuyển đổi :param thành regex
        $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
}
