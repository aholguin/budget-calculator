<?php
declare(strict_types=1);

namespace App;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    public function __construct(private readonly string $view, private readonly array $parameters)
    {
    }

    static function make($view, $parameters): static
    {
        return new static($view, $parameters);
    }

    public function __toString(): string
    {
        return $this->render();
    }

    private function render(): string
    {
        $loader = new FilesystemLoader(__DIR__ . '/../views/');
        $twig = new Environment($loader);

        return $twig->render("$this->view.twig", ['budgetHistory' => $this->parameters]);
    }
}