<?php
class Router {
    public function route() {
        $url = isset($_GET['url']) ? explode("/", filter_var(rtrim($_GET['url'], "/"), FILTER_SANITIZE_URL)) : [];

        $controllerName = !empty($url[0]) ? ucfirst($url[0]) . "Controller" : "HomeController";
        $methodName = isset($url[1]) ? $url[1] : "index";

        $controllerPath = "../app/controllers/" . $controllerName . ".php";

        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controller = new $controllerName();

            if (method_exists($controller, $methodName)) {
                $controller->{$methodName}();
            } else {
                echo "Metod ne postoji.";
            }
        } else {
            echo "Kontroler ne postoji.";
        }
    }
}
