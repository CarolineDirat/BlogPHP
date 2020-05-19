<?php

namespace App\Application;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Application\Twig\FormExtension;

final class TwigRenderer
{
    /**
     * Twig environnement.
     *
     * @var Environment
     */
    private $twig;

    /**
     * Loader of twig.
     *
     * @var FilesystemLoader
     */
    private $loader;

    public function __construct(string $path)
    {
        $this->loader = new FilesystemLoader($path);
        $this->twig = new Environment($this->loader, []);
        $this->twig->addExtension(new FormExtension);
    }

    /**
     * Permet de rajouter un chemin pour charger les vues.
     *
     * @param string  $namespace namespace corresponding to th path
     * @param ?string $path      path to add
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    /**
     * Permet de rendre une vue
     * Le chemin peut être précisé avec des namespace rajoutés via addPath().
     *
     * @param string $view   the name of the view
     * @param array  $params data to give to the view
     */
    public function render(string $view, array $params = []): void
    {
        $this->twig->display($view.'.twig', $params);
    }

    /**
     * Permet de rajouter des variables globales à toutes les vues.
     *
     * @param string $key   key of the global variable
     * @param mixed  $value value of the global variable
     */
    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }
}
