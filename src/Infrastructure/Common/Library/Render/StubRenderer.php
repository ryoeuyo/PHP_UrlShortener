<?php

namespace App\Infrastructure\Common\Library\Render;

use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;

final readonly class StubRenderer implements TemplateRendererInterface
{
    public function __construct(
        private Filesystem $fs,
        private string $projectDir,
    ) {
    }

    public function render(string $template, array $parameters = []): string
    {
        $templatePath = sprintf('%s/templates/stubs/%s', $this->projectDir, $template);

        if (!$this->fs->exists($templatePath)) {
            throw new RuntimeException(sprintf('Template "%s" does not exist', $templatePath));
        }

        $content = file_get_contents($templatePath);

        if ($content === false) {
            throw new RuntimeException(sprintf('Template "%s" does not exist', $templatePath));
        }

        $keys = array_map(
            fn (string $key): string => sprintf('{{ %s }}', $key),
            $parameters
        );

        return str_replace(
            $keys,
            array_values($parameters),
            $content,
        );
    }
}
