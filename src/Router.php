<?php
namespace App;

/**
 * Routeur de l'application
 */
class Router{

    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var AltoRouter
     */
    private $router;

    /**
     * constructeur du routeur 
     * @param string $viewPath
     */
    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();
    }


    /**
     * renvoi l'url récuperer en GET
     * @param string $url
     * @param string $view
     * @param string|null $name
     * @return self
     */
    public function get(string $url, string $view, ?string $name = null)
    {
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    /**
     * revoi l'url avec les paramètres
     * @param string $name
     * @param array $params
     * @return self
     */
    public function url(string $name, array $params = [])
    {
       
        return $this->router->generate($name, $params);
    }

    /**
     * renvoi la route séléctionné
     * @return self
     */
    public function run()
    {
        $match = $this->router->match();
        $view = $match['target'];
        $router = $this;
        ob_start();
        require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        $content = ob_get_clean();
        require $this->viewPath . DIRECTORY_SEPARATOR . 'layouts/default.php';
        return $this;
    }
}