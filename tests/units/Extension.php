<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\tests\units;

use atoum;
use Tidal\Behat\BaseExtension;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Behat\Testwork\ServiceContainer\ExtensionManager;

use Tidal\Behat\BaseExtension\Contract\Context\ContextClass\ClassResolverInterface;

/**
 * Class unit\Tidal\Behat\BaseExtension\ExtensionTest
 *
 * @php 7.0
 */
class Extension extends atoum
{
    public function test_can_access_config_key()
    {
        $key = 'foo';

        $this
            ->given(
                $extension = new BaseExtension\Extension()
            )
            ->and(
                $extension->setConfigKey($key)
            )

            ->then()
            ->string(
                $extension->getConfigKey()
            )
            ->isEqualTo(
                $key
            )
            ;
    }

    public function test_access_class_resolver()
    {

        $this
            ->given(
                $extension = new BaseExtension\Extension()
            )
            ->and(
                $resolver = $this->createClassResolverMock()
            )
            ->then(
                $extension->setClassResolver($resolver)
            )

            ->and()
            ->object(
                $extension->getClassResolver()
            )
            ->isEqualTo(
                $resolver
            )
        ;
    }

    public function test_can_access_namespace()
    {
        $key = 'foo';

        $this
            ->given(
                $extension = new BaseExtension\Extension()
            )
            ->and(
                $extension->setNamespace($key)
            )

            ->then()
            ->string(
                $extension->getNamespace()
            )
            ->isEqualTo(
                $key
            )
        ;
    }

    public function test_namespace_defaults()
    {
        $key = 'default';

        $this
            ->given(
                $extension = new BaseExtension\Extension()
            )

            ->then()
            ->string(
                $extension->getNamespace()
            )
            ->isEqualTo(
                $key
            )
        ;
    }

    public function test_load_registers_class_resolver()
    {
        $this

            // setup
            ->given(
                $extension = new BaseExtension\Extension()
            )
            ->and(
                $builder = $this->createContainerBuilderMock()
            )
            ->and(
                $test = $this
            )
            ->and(
                $validate = function(string $id, Definition $definition) use($extension, $builder, $test) {

                    $test
                        ->boolean(
                            $extension->getNamespace().'.class_resolver' === $id
                        )
                        ->isTrue()

                        ->boolean(
                            $definition->hasTag(ContextExtension::CLASS_RESOLVER_TAG)
                        )
                        ->isTrue();

                    return $definition;
                }
            )
            ->and(
                $builder->getMockController()->setDefinition = $validate
            )

            // test
            ->then(
                $extension->load($builder, [])
            )
            ->and()
            ->mock(
                $builder
            )
            ->call(
                'setDefinition'
            )
            ->once()
        ;
    }


    public function test_stub_methods_throw_no_error()
    {
        $key = 'default';

        $this
            ->given(
                $extension = new BaseExtension\Extension()
            )
            ->and(
                $manager = new ExtensionManager([])
            )
            ->and(
                $builder = $this->createContainerBuilderMock()
            )
            ->and(
                $node = $this->newMockInstance(
                    ArrayNodeDefinition::class,
                    null,
                    null,
                    [
                        $key
                    ]
                )
            )

            ->then()
            ->boolean(
                (function () use($extension, $manager, $builder, $node) {
                    try {
                        $extension->initialize($manager);
                        $extension->process($builder);
                        $extension->configure($node);
                    } catch (\Throwable $t) {
                        return false;
                    }

                    return true;
                })()
            )
            ->given(
                $extension = new BaseExtension\Extension()
            )
            ->given(
                $extension = new BaseExtension\Extension()
            )
            ->given(
                $extension = new BaseExtension\Extension()
            )

            ->then()
            ->string(
                $extension->getNamespace()
            )
            ->isEqualTo(
                $key
            )
        ;
    }


    /**
     * @return object|ContainerBuilder
     */
    private function createContainerBuilderMock()
    {
        return $this->newMockInstance(
            ContainerBuilder::class
        );
    }

    /**
     * @return object|ClassResolverInterface
     */
    private function createClassResolverMock()
    {
        return $this->newMockInstance(
            ClassResolverInterface::class
        );
    }
}

