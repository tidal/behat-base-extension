<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\Behavior;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\ServiceContainer\ExtensionManager;

use Tidal\Behat\BaseExtension\Contract\Context\ContextClass\ClassResolverInterface;

/**
 * Trait Tidal\Behat\BaseExtension\Behavior\ExtensionTrait *
 */
trait ExtensionTrait
{
    /**
     * @var string
     */
    private $configKey;

    /**
     * @var ClassResolverInterface
     */
    private $classResolver;

    /**
     * @var string
     */
    private $namespace = 'default';

    /**
     * @param mixed $configKey
     */
    public function setConfigKey($configKey)
    {
        $this->configKey = $configKey;
    }

    /**
     * Returns the extension config key.
     *
     * @return string
     */
    public function getConfigKey()
    {
        return $this->configKey;
    }

    /**
     * @param ClassResolverInterface $classResolver
     */
    public function setClassResolver(ClassResolverInterface $classResolver)
    {
        $this->classResolver = $classResolver;
    }

    /**
     * @return ClassResolverInterface
     */
    public function getClassResolver(): ClassResolverInterface
    {
        return $this->classResolver;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace(string $namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return isset($this->namespace)
            ? $this->namespace
            : $this->configKey;
    }

    public function initialize(ExtensionManager $extensionManager)
    {
        $this->doInitialize($extensionManager);
    }

    private function doInitialize(ExtensionManager $extensionManager)
    {

    }

    public function process(ContainerBuilder $container)
    {
        $this->doProcess($container);
    }

    private function doProcess(ContainerBuilder $container)
    {

    }

    public function load(ContainerBuilder $container, array $config)
    {
        $this->doLoad($container, $config);
    }

    private function doLoad(ContainerBuilder $container, array $config)
    {
        $this->registerClassResolver(
            $container
        );
    }

    public function configure(ArrayNodeDefinition $builder)
    {
        $this->doConfigure($builder);
    }

    private function doConfigure(ArrayNodeDefinition $builder)
    {

    }

    private function registerClassResolver(ContainerBuilder $container)
    {
        $definition = new Definition();
        $definition->setFactory(function () {
            return $this->getClassResolver();
        });
        $definition->addTag(ContextExtension::CLASS_RESOLVER_TAG);
        $id = $this->getNamespace().'.class_resolver';
        $container->setDefinition($id, $definition);
    }
}

