<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\tests\units\Behavior\Context\ContextClass;

use Tidal\Behat\BaseExtension\Context\ContextClass\ClassResolver as TestedClassResolver;

/**
 * Trait Tidal\Behat\BaseExtension\tests\units\Behavior\Context\ContextClass\ClassResolverTrait *
 */
trait ClassResolverTrait
{
    public function test_context_namespace_is_not_set()
    {
        $this
            ->given($resolver = new TestedClassResolver())
            ->then()
            ->string($resolver->getContextNamespace())
            ->isIdenticalTo('')
        ;
    }

    public function test_can_access_context_namespace()
    {
        $name = 'foo';

        $this
            ->given($resolver = new TestedClassResolver())
            ->if($resolver->setContextNamespace($name))
            ->then()
            ->string($resolver->getContextNamespace())
            ->isIdenticalTo($name)
        ;
    }

    public function test_context_namespace_is_immutable()
    {
        $name1 = 'foo';
        $name2 = 'bar';

        $this
            ->given($resolver = new TestedClassResolver())
            ->if($resolver->setContextNamespace($name1))
            ->and($resolver->setContextNamespace($name2))
            ->then()
            ->string($resolver->getContextNamespace())
            ->isIdenticalTo($name1)
        ;
    }

    public function test_can_add_context_aliases()
    {
        $aliases = [
            'foo',
            'bar',
            'baz'
        ];

        $this->given($resolver = new TestedClassResolver());

        foreach ($aliases as $alias) {
            $this
                ->given($resolver->addContextAlias($alias))
                ->then()
                ->boolean($resolver->hasContextAlias($alias))
                ->isTrue()
            ;
        }
    }

    public function test_can_remove_context_aliases()
    {
        $aliases = [
            'foo',
            'bar',
            'baz'
        ];

        $this->given($resolver = new TestedClassResolver());

        foreach ($aliases as $alias) {
            $this
                ->given($resolver->addContextAlias($alias))
                ->given($resolver->removeContextAlias($alias))
                ->then()
                ->boolean($resolver->hasContextAlias($alias))
                ->isFalse()
            ;
        }
    }

    public function test_does_not_support_invalid_namespace()
    {
        $ns = 'foo:';
        $name = 'bar';
        $nsName = 'bar:foo';

        $this
            ->given($resolver = new TestedClassResolver())

            ->if($resolver->setContextNamespace($ns))

            ->then()
            ->boolean($resolver->supportsClass($name))
            ->isFalse()

            ->and()
            ->boolean($resolver->supportsClass($nsName))
            ->isFalse()
        ;
    }

    public function test_does_not_support_invalid_alias()
    {
        $ns = 'foo:';
        $alias = 'bar';
        $name = 'foo';
        $nsName = 'foo:foo';

        $this
            ->given($resolver = new TestedClassResolver())

            ->if($resolver->setContextNamespace($ns))
            ->and($resolver->addContextAlias($alias))

            ->then()
            ->boolean($resolver->supportsClass($name))
            ->isFalse()

            ->and()
            ->boolean($resolver->supportsClass($nsName))
            ->isFalse()
        ;
    }

    public function test_does_not_support_plain_namespace()
    {
        $alias = 'foo';

        $this
            ->given($resolver = new TestedClassResolver())

            ->if($resolver->setContextNamespace($alias))

            ->then()
            ->boolean($resolver->supportsClass($alias))
            ->isFalse()
        ;
    }

    public function test_supports_valid_alias()
    {
        $alias = 'foo';

        $this
            ->given($resolver = new TestedClassResolver())

            ->if($resolver->addContextAlias($alias))

            ->then()
            ->boolean($resolver->supportsClass($alias))
            ->isTrue()
        ;
    }

    public function test_supports_valid_namespace_alias()
    {
        $ns = 'foo';
        $alias = 'bar';
        $class = $ns.$alias;

        $this
            ->given($resolver = new TestedClassResolver())

            ->if($resolver->setContextNamespace($ns))
            ->and($resolver->addContextAlias($alias))

            ->then()
            ->boolean($resolver->supportsClass($class))
            ->isTrue()
        ;
    }
}
