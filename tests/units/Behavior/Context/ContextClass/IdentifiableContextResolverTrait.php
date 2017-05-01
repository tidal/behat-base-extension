<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\tests\units\Behavior\Context\ContextClass;

use Tidal\Behat\BaseExtension\Context\ContextDefinition;
use Tidal\Behat\BaseExtension\Context\ContextClass\ClassResolver as TestedClassResolver;
use Tidal\Behat\BaseExtension\Context\ContextDefinitionException;

use Behat\Behat\Context\Context;

/**
 * Trait Tidal\Behat\BaseExtension\tests\units\Behavior\Context\ContextClass\IdentifiableContextResolverTrait *
 */
trait IdentifiableContextResolverTrait
{
    use ClassResolverTrait;

    /**
     * @var bool
     */
    protected $definitionClassGenerated = false;

    /**
     * @var string
     */
    protected $definitionMockClass = 'DefinitionMock';

    /**
     * @var string
     */
    protected $contextMockClass = 'ContextMock';


    public function test_can_add_definition()
    {
        $this
            ->given($resolver = new TestedClassResolver())
            ->and($definition = $this->createDefinitionMock())
            ->then()
            ->boolean($resolver->hasDefinition($definition))
            ->isFalse()
            ->and()
            ->if($resolver->addDefinition($definition))
            ->then()
            ->boolean($resolver->hasDefinition($definition))
            ->isTrue();
    }

    public function test_can_access_definition_by_id()
    {
        $this
            ->given($resolver = new TestedClassResolver())
            ->and($definition = $this->createDefinitionMock())
            ->then()
            ->boolean($resolver->hasDefinitionId($definition->getId()))
            ->isFalse()
            ->and()
            ->if($resolver->addDefinition($definition))
            ->then()
            ->boolean($resolver->hasDefinitionId($definition->getId()))
            ->isTrue();
    }

    public function test_rejects_definitions_without_id()
    {
        $this
            ->given($resolver = new TestedClassResolver())
            ->and($definition = $this->createDefinitionMock('', ''))
            ->then()
            ->string($definition->getId())
            ->isEqualTo('')
            ->and()
            ->exception(
                function () use ($resolver, $definition) {
                    // This code throws an exception
                    $resolver->addDefinition($definition);
                }
            )
            ->isInstanceOf(ContextDefinitionException::class);
    }

    public function test_rejects_definitions_with_known_id()
    {
        $this
            ->given($resolver = new TestedClassResolver())
            ->and($definition = $this->createDefinitionMock())
            ->and($resolver->addDefinition($definition))
            ->then()
            ->exception(
                function () use ($resolver, $definition) {
                    // This code throws an exception
                    $resolver->addDefinition($definition);
                }
            )
            ->isInstanceOf(ContextDefinitionException::class);
    }

    public function test_rejects_definitions_with_unique_namespace()
    {
        $this
            ->given($resolver = new TestedClassResolver())
            ->and($definition1 = $this->createDefinitionMock('foo:', 'bar'))
            ->and($definition2 = $this->createDefinitionMock('bar:', 'foo'))
            ->and($resolver->addDefinition($definition1))
            ->then()
            ->exception(
                function () use ($resolver, $definition2) {
                    // This code throws an exception
                    $resolver->addDefinition($definition2);
                }
            )
            ->isInstanceOf(ContextDefinitionException::class);
    }

    public function test_definition_sets_namespace()
    {
        $ns = 'bar:';
        $name = 'foo';

        $this
            ->given($resolver = new TestedClassResolver())
            ->and($definition = $this->createDefinitionMock($ns, $name))
            ->and($resolver->addDefinition($definition))
            ->then()
            ->string($resolver->getContextNamespace())
            ->isEqualTo($ns);
    }

    public function test_definition_adds_alias()
    {
        $ns = 'bar:';
        $name = 'foo';

        $this
            ->given($resolver = new TestedClassResolver())
            ->and($definition = $this->createDefinitionMock($ns, $name))
            ->and($resolver->addDefinition($definition))
            ->then()
            ->boolean($resolver->hasContextAlias($name))
            ->isTrue();
    }

    public function test_does_not_resolve_unknown_class()
    {
        $class = 'foo';

        $this
            ->given($resolver = new TestedClassResolver())
            ->then()
            ->boolean($resolver->supportsClass($class))
            ->isFalse()
            ->and()
            ->exception(
                function () use ($resolver, $class) {
                    $resolver->resolveClass($class);
                }
            )
            ->isInstanceOf(ContextDefinitionException::class);
    }

    public function test_resolves_known_class()
    {
        $ns = 'bar:';
        $name = 'foo';

        $this
            ->given($resolver = new TestedClassResolver())
            ->and($definition = $this->createDefinitionMock($ns, $name))
            ->and($resolver->addDefinition($definition))
            ->then()
            ->string($resolver->resolveClass($ns . $name))
            ->isEqualTo(
                $definition->getClass()
            );
    }


    /**
     * @param string $ns
     * @param string $name
     * @return ContextDefinition
     */
    protected function createDefinitionMock($ns = 'foo:', $name = 'bar')
    {
        $definitionMockClass = $this->createDefinitionMockClass();
        $definitionMock = new $definitionMockClass;
        $contextMockClass = $this->getMockClass(
            $this->contextMockClass
        );

        $this->calling($definitionMock)->getNamespace = $ns;
        $this->calling($definitionMock)->getName = $name;
        $this->calling($definitionMock)->getId = $ns . $name;
        $this->calling($definitionMock)->getClass = $contextMockClass;

        return $definitionMock;
    }

    /**
     * @return string
     */
    protected function createDefinitionMockClass()
    {
        if (!$this->definitionClassGenerated) {

            $this->getMockGenerator()
                ->generate(
                    ContextDefinition::class,
                    $this->getMockNamespace(),
                    $this->definitionMockClass
                );

            $this->getMockGenerator()
                ->generate(
                    Context::class,
                    $this->getMockNamespace(),
                    $this->contextMockClass
                );

            $this->definitionClassGenerated = true;
        }

        return $this->getMockClass($this->definitionMockClass);
    }

    /**
     * @param $className
     * @return string
     */
    protected function getMockClass($className)
    {
        return $this->getMockNamespace() . '\\' . $className;
    }

    /**
     * @return string
     */
    protected function getMockNamespace()
    {
        return __NAMESPACE__;
    }
}

