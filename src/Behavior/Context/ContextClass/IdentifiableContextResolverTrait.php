<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\Behavior\Context\ContextClass;

use Tidal\Behat\BaseExtension\Contract\Context\ContextDefinitionInterface;
use Tidal\Behat\BaseExtension\Context\ContextDefinitionException;

/**
 * Trait Tidal\Behat\BaseExtension\Behavior\Context\ContextClass\IdentifiableContextResolverTrait *
 */
trait IdentifiableContextResolverTrait
{
    use ClassResolverTrait;

    /**
     * @var array
     */
    protected $contextDefinitions = [];

    /**
     * Resolves context class.
     *
     * @param string $contextClass
     *
     * @return string
     */
    public function resolveClass($contextClass)
    {
        if (!$this->hasDefinitionId($contextClass)) {
            throw new ContextDefinitionException(
                sprintf(
                    "Context class with id '%s' does not exist.",
                    $contextClass
                )
            );
        }

        return $this->getDefinition(
            $contextClass
        )->getClass();
    }

    /**
     * @param ContextDefinitionInterface $definition
     */
    public function addDefinition(ContextDefinitionInterface $definition)
    {
        $this->validateDefinition($definition);

        $this->setContextNamespace(
            $definition->getNamespace()
        );
        $this->addContextAlias(
            $definition->getName()
        );
        $this->registerDefinition(
            $definition
        );
    }

    /**
     * @param ContextDefinitionInterface $definition
     * @return bool
     */
    public function hasDefinition(ContextDefinitionInterface $definition) : bool
    {
        return $this->hasDefinitionId(
            $definition->getId()
        );
    }

    /**
     * @param string $definitionId
     * @return bool
     */
    public function hasDefinitionId(string $definitionId) : bool
    {
        return isset($this->contextDefinitions[$definitionId]);
    }

    /**
     * @param string $definitionId
     * @return null|ContextDefinitionInterface
     */
    public function getDefinition(string $definitionId) : ContextDefinitionInterface
    {
        return $this->hasDefinitionId($definitionId)
            ? $this->contextDefinitions[$definitionId]
            : null;
    }

    /**
     * @param ContextDefinitionInterface $definition
     */
    protected function registerDefinition(ContextDefinitionInterface $definition)
    {
        $this->contextDefinitions[$definition->getId()] = $definition;
    }

    protected function validateDefinition(ContextDefinitionInterface $definition)
    {
        // definition must not have an empty id
        if (trim($definition->getId()) === '') {
            throw new ContextDefinitionException(
                'Empty context definition id'
            );
        }
        // definition's id must be unique
        if ($this->hasDefinition($definition)) {
            throw new ContextDefinitionException(
                sprintf(
                    "Context definition with id '%s' has already been added.",
                    $definition->getId()
                )
            );
        }
        // if we have no namespace yet, ignore check for namespace
        if (!$this->hasContextNamespace()) {
            return;
        }
        // make sure the context's namespace follows the the known ones
        if ($this->getContextNamespace() !== $definition->getNamespace()) {
            throw new ContextDefinitionException(
                sprintf(
                    "Context definition must have namespace '%s'. Given '%s'",
                    $this->getContextNamespace(),
                    $definition->getNamespace()
                )
            );
        }
    }
}

