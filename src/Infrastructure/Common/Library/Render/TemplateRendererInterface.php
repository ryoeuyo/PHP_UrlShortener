<?php

namespace App\Infrastructure\Common\Library\Render;

interface TemplateRendererInterface
{
    /**
     * @param array<string, mixed> $parameters
     */
    public function render(string $template, array $parameters = []): string;
}
