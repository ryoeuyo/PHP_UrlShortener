<?php

declare(strict_types=1);

namespace Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Attributes\TestRule;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

final class ArchitectureTest
{
    // ======================================================
    // DEPENDENCY RULES
    // ======================================================

    #[TestRule]
    public function application_must_not_depend_on_infrastructure(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\/', true)
            )
            ->shouldNot()
            ->dependOn()
            ->classes(
                Selector::inNamespace('/^App\\\\Infrastructure\\\\/', true)
            )
            ->because('Application layer must not depend on Infrastructure');
    }

    #[TestRule]
    public function application_must_not_depend_on_presentation(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\/', true)
            )
            ->shouldNot()
            ->dependOn()
            ->classes(
                Selector::inNamespace('/^App\\\\Presentation\\\\/', true)
            )
            ->because('Application layer must not depend on Presentation');
    }

    #[TestRule]
    public function domain_must_not_depend_on_outer_application_layers(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\Domain\\\\/', true)
            )
            ->shouldNot()
            ->dependOn()
            ->classes(
                Selector::inNamespace(
                    '/^App\\\\Application\\\\[A-Za-z]+\\\\(Action|UseCase|Assert|Policy)\\\\/',
                    true,
                ),
                Selector::inNamespace('/^App\\\\Infrastructure\\\\/', true),
                Selector::inNamespace('/^App\\\\Presentation\\\\/', true)
            )
            ->because('Domain must not depend on outer layers');
    }

    #[TestRule]
    public function action_must_not_depend_on_use_case(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\Action\\\\/', true)
            )
            ->shouldNot()
            ->dependOn()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\UseCase\\\\/', true)
            )
            ->because('Action must be atomic and must not orchestrate use cases');
    }

    #[TestRule]
    public function use_case_must_not_depend_on_use_case(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\UseCase\\\\/', true)
            )
            ->shouldNot()
            ->dependOn()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\UseCase\\\\/', true)
            )
            ->because('UseCase should not call another UseCase directly');
    }

    // ======================================================
    // OPTIONAL: PRESENTATION / ORM BOUNDARY
    // ======================================================

    #[TestRule]
    public function presentation_must_not_depend_on_doctrine_entities(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Presentation\\\\/', true)
            )
            ->shouldNot()
            ->dependOn()
            ->classes(
                Selector::inNamespace(
                    '/^App\\\\Infrastructure\\\\Persistence\\\\Doctrine\\\\Entity\\\\/',
                    true,
                )
            )
            ->because('Presentation must not expose Doctrine persistence models');
    }

    // ======================================================
    // STRUCTURAL RULES
    // ======================================================

    #[TestRule]
    public function request_dtos_should_be_readonly(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace(
                    '/^App\\\\Application\\\\[A-Za-z]+\\\\Domain\\\\Request\\\\/',
                    true,
                )
            )
            ->excluding(Selector::isInterface())
            ->should()
            ->beReadonly()
            ->because('Request DTOs should be immutable');
    }

    #[TestRule]
    public function request_dtos_should_be_final(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace(
                    '/^App\\\\Application\\\\[A-Za-z]+\\\\Domain\\\\Request\\\\/',
                    true,
                )
            )
            ->excluding(Selector::isInterface())
            ->should()
            ->bereadonly()
            ->because('Request DTOs should be final');
    }

    #[TestRule]
    public function actions_should_be_readonly(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\Action\\\\/', true)
            )
            ->excluding(Selector::isInterface())
            ->should()
            ->beReadonly()
            ->because('Actions should be readonly');
    }

    #[TestRule]
    public function actions_should_be_final(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\Action\\\\/', true)
            )
            ->excluding(Selector::isInterface())
            ->should()
            ->befinal()
            ->because('Actions should be final');
    }

    #[TestRule]
    public function use_cases_should_be_readonly(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\UseCase\\\\/', true)
            )
            ->excluding(Selector::isInterface())
            ->should()
            ->beReadonly()
            ->because('UseCases should be readonly');
    }

    #[TestRule]
    public function use_cases_should_be_final(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\UseCase\\\\/', true)
            )
            ->excluding(Selector::isInterface())
            ->should()
            ->beFinal()
            ->because('UseCases should be final');
    }

    // ======================================================
    // NAMING RULES
    // ======================================================

    #[TestRule]
    public function use_cases_should_be_named_correctly(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\UseCase\\\\/', true)
            )
            ->should()
            ->beNamed('/.*UseCase$/', true);
    }

    #[TestRule]
    public function actions_should_be_named_correctly(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\Action\\\\/', true)
            )
            ->should()
            ->beNamed('/.*Action$/', true);
    }

    #[TestRule]
    public function interfaces_should_be_named_with_interface_suffix(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::isInterface())
            ->should()
            ->beNamed('/.*Interface$/', true);
    }

    // ======================================================
    // PUBLIC METHOD RULES
    // ======================================================

    #[TestRule]
    public function use_cases_should_have_only_one_public_method(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\UseCase\\\\/', true)
            )
            ->should()
            ->haveOnlyOnePublicMethod()
            ->because('UseCases should expose a single entrypoint');
    }

    #[TestRule]
    public function actions_should_have_only_one_public_method(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App\\\\Application\\\\[A-Za-z]+\\\\Action\\\\/', true)
            )
            ->should()
            ->haveOnlyOnePublicMethod()
            ->because('Actions should expose a single entrypoint');
    }
}
