<?php

namespace App\Infrastructure\Console\Command;

use App\Infrastructure\Common\Library\Render\TemplateRendererInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(name: 'make:policy', description: 'Make policy')]
final class MakePolicyCommand extends Command
{
    public function __construct(
        private readonly TemplateRendererInterface $renderer,
        private readonly Filesystem $fs,
        private readonly string $projectDir,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('entity', InputArgument::REQUIRED)
            ->addArgument('policy', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entity = $input->getArgument('entity');
        $policy = $input->getArgument('policy') ?? "{$entity}Policy";

        $path = sprintf(
            '%s/src/Application/%s/Domain/Policy',
            $this->projectDir,
            $entity
        );

        $filePath = $path . '/' . $policy . '.php';

        if ($this->fs->exists($filePath)) {
            $output->writeln('<error>Policy already exists</error>');
            return Command::FAILURE;
        }

        $this->fs->mkdir($path);
        $content = $this->renderer->render('policy.stub.tpl', [
            'entity' => $entity,
            'policy' => $policy,
        ]);

        $this->fs->dumpFile($filePath, $content);
        $output->writeln("<info>Policy created: $filePath</info>");

        return Command::SUCCESS;
    }
}
