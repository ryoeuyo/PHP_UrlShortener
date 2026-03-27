<?php

namespace App\Infrastructure\Console\Command;

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
        $content = $this->generatePolicy($entity, $policy);

        $this->fs->dumpFile($filePath, $content);
        $output->writeln("<info>Policy created: $filePath</info>");

        return Command::SUCCESS;
    }

    private function generatePolicy(string $entity, string $policy): string
    {
        return <<<PHP
<?php

declare(strict_types=1);

namespace App\\Application\\$entity\\Domain\\Policy;

use Application\\Common\\Domain\\Exception\\ForbiddenActionException;
use Application\\EventManagement\\Common\\Domain\\Enum\\PolicyAction;
use Application\\EventManagement\\Common\\Domain\\Security\\AuthorizationContext;

final readonly class $policy
{
    public function assert(AuthorizationContext \$ctx, PolicyAction \$action): void
    {
        if (\$this->can(\$ctx, \$action) === false) {
            throw new ForbiddenActionException();
        }
    }

    private function can(AuthorizationContext \$ctx, PolicyAction \$action): bool
    {
        return match (\$action) {
            PolicyAction::View => \$this->canView(\$ctx),
            PolicyAction::Edit => \$this->canEdit(\$ctx),
            PolicyAction::Delete => \$this->canDelete(\$ctx),
            PolicyAction::Create => \$this->canCreate(\$ctx),
        };
    }

    private function canView(AuthorizationContext \$ctx): bool
    {
        return false;
    }

    private function canEdit(AuthorizationContext \$ctx): bool
    {
        return false;
    }

    private function canDelete(AuthorizationContext \$ctx): bool
    {
        return false;
    }

    private function canCreate(AuthorizationContext \$ctx): bool
    {
        return false;
    }
}
PHP;
    }
}
