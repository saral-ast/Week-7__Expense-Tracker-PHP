<?php 
namespace Core;

// use Core\middleware\Middleware;

// use Core\middleware\Middleware;
 class Router{
    protected $routes = [];

    protected function add($uri,$controller,$method){
        $this->routes[]=[
            'uri' => $uri,
            'controller'=> $controller,
            'method' => $method,
            'middleware' => null
        ];
        return $this;
    }
    public function get($uri,$controller){
          return  $this->add($uri,$controller,'GET');
    }

    public function post($uri,$controller){
       return $this->add($uri,$controller,'POST');
    }

    public function delete($uri,$controller){
        return $this->add($uri,$controller,'DELETE');
    }

    public function patch($uri,$controller,){
        return $this->add($uri,$controller,'PATCH');
    }

    public function put($uri,$controller) {
        return $this->add($uri,$controller,'PUT');
    }

    public function only($key){
          $this->routes[array_key_last($this->routes)]['middleware'] = $key;
          return $this;
    }

    public function route($uri,$method){
        foreach($this->routes as $route){
            if($route['uri'] === $uri && $route['method'] === strtoupper($method)){
                // dd($uri);
                return require base_path($route['controller']);
                
            }
        }
         $this->abort(Response::NOT_FOUND);

    }

    protected function abort($code = 404){
        http_response_code($code);
        require base_path("view/{$code}.php");
        die();
    }

    public function prevUrl(){
        return $_SERVER['HTTP_REFERER'];
    }


 }





