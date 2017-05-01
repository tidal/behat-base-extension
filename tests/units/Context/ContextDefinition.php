<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\tests\units\Context;

use atoum;

use Tidal\Behat\BaseExtension\Context\ContextDefinition as TestedContextDefinition;
use Tidal\Behat\BaseExtension\Contract\Context\ContextDefinitionInterface;
use Tidal\Behat\BaseExtension\Context\ContextDefinitionException;

use Behat\Behat\Context\Context;

/**
 * Class Tidal\Behat\BaseExtension\tests\units\Context\ContextDefinition *
 *
 * @php 7.0
 */
class ContextDefinition extends atoum
{
    public function test_is_context_definition()
    {
        $this->object(
            $this->newTestedInstance
        )
            ->isInstanceOf(ContextDefinitionInterface::class);
    }

    public function test_can_access_name()
    {
        $name = 'foo';

        $this
            ->given($definition = new TestedContextDefinition())
            ->if($definition->setName($name))
            ->then()
            ->string($definition->getName())
            ->isIdenticalTo($name)
        ;
    }

    public function test_can_access_namespace()
    {
        $name = 'foo';

        $this
            ->given($definition = new TestedContextDefinition())
            ->if($definition->setNamespace($name))
            ->then()
            ->string($definition->getNamespace())
            ->isIdenticalTo($name)
        ;
    }

    public function test_id_is_concenated_ns_and_name()
    {
        $name = 'foo';

        $this
            ->given($definition = new TestedContextDefinition())
            ->if($definition->setNamespace($name))
            ->if($definition->setName($name))
            ->then()
            ->string($definition->getId())
            ->isIdenticalTo($name.$name)
        ;
    }

    public function test_id_is_empty_without_ns_and_name()
    {
        $this
            ->given($definition = new TestedContextDefinition())
            ->then()
            ->string($definition->getId())
            ->isIdenticalTo('')
        ;
    }

    public function test_does_not_accept_non_existing_classes()
    {
        $cls = 'foo';

        $this->boolean(
            class_exists($cls)
        )->isFalse();

        $this
            // creation of a new instance of the tested class
            ->given($definition = new TestedContextDefinition())
            ->then()
            ->exception(
                function() use($definition, $cls) {
                    // This code throws an exception
                    $definition->setClass($cls);
                }
            )
            ->isInstanceOf(ContextDefinitionException::class)
        ;
    }

    public function test_does_not_accept_non_context_classes()
    {
        $cls = '\stdClass';

        $this->boolean(
            class_exists($cls)
        )->isTrue();

        $this
            // creation of a new instance of the tested class
            ->given($definition = new TestedContextDefinition())
            ->then()
            ->exception(
                function() use($definition, $cls) {
                    // This code throws an exception
                    $definition->setClass($cls);
                }
            )
            ->isInstanceOf(ContextDefinitionException::class)
        ;
    }

    public function test_accepts_context_classes()
    {
        $cls = 'ContextClass';
        $this->getMockGenerator()
            ->generate(Context::class, __NAMESPACE__, $cls);
        $clsName = __NAMESPACE__.'\\'.$cls;

        $this->boolean(
            class_exists($clsName)
        )->isTrue();

        $this
            ->given($definition = new TestedContextDefinition())
            ->if($definition->setClass($clsName))
            ->then()
            ->string($definition->getClass())
            ->isIdenticalTo($clsName)
        ;
    }
}

