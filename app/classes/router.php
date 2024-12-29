<?php
    class Router {
        protected $routes = [];

        public function add($route, $file) {
            $this->routes[$route] = $file; // this route...
        }

        public function route($uri) {
            foreach ($this->routes as $route => $file) {
                list($components, $parts) = $this->expl($route, $uri);

                if (count($components) == count($parts)) {
                    $match = true;
                    $params = [];
                    $keys = array_keys($components);

                    foreach ($keys as $i) {
                        $component = $components[$i];
                        if (strpos($component, '[') === 0) {
                            if (strpos($component, ']') === strlen($component) - 1) {

                                $name = substr($component, 1, -1);
                                if (empty($parts[$i])) {
                                    $match = false;
                                    break;
                                } else {

                                    if (empty($parts[$i])) { // empty parts...
                                        $match = false;
                                        break;
                                    }
                                }
                                $params[$name] = $parts[$i];
                            } else {
                                // else...
                            }
                        } elseif ($component !== $parts[$i]) {
                            $match = false;
                            break;
                        }
                    }
                    if ($match) {
                        return $file; // return this file...
                    }
                }
            }
            return 'pages/error.php';
        }

        private function expl(string $route, string $uri): array {
            $components = explode(
                '/', trim($route, '/'));
            $parts = explode('/', trim($uri, '/')); // explode route...
            return [
                $components, 
                $parts
            ];
        }
    }
?>