<?php
namespace App\Application;

final class TwigRenderer
{
    
    /**
     * Twig environnement
     * 
     * @var \Twig\Environment
     */
    private $twig;
    
    /**
     * Loader of twig
     * 
     * @var \Twig\Loader\FilesystemLoader
     */
    private $loader;

    public function __construct(string $path)
    {
        $this->loader = new \Twig\Loader\FilesystemLoader($path);
        $this->twig = new \Twig\Environment($this->loader, []);
    }

    /**
     * Permet de rajouter un chemin pour charger les vues
     * 
     * @param string      $namespace namespace corresponding to th path
     * @param null|string $path      path to add
     * 
     * @return void
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    /**
     * Permet de rendre une vue
     * Le chemin peut être précisé avec des namespace rajoutés via addPath()
     * 
     * @param string $view   the name of the view
     * @param array  $params data to give to the view
     * 
     * @return void
     */
    public function render(string $view, array $params = []): void
    {
        exit($this->twig->render($view . '.twig', $params));
    }

    /**
     * Permet de rajouter des variables globales à toutes les vues
     *
     * @param string $key   key of the global variable
     * @param mixed  $value value of the global variable
     * 
     * @return void
     */
    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }
}
