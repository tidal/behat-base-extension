<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\Contract\Context\ContextClass;

use Tidal\Behat\BaseExtension\Contract\Context\ContextDefinitionInterface;

/**
 * Interface Tidal\Behat\BaseExtension\Contract\Context\ContextClass\IdentifiableContextResolverInterface *
 */
interface IdentifiableContextResolverInterface extends ClassResolverInterface
{
    /**
     * @param ContextDefinitionInterface $definition
     */
    public function addDefinition(ContextDefinitionInterface $definition);

    /**
     * @param ContextDefinitionInterface $definition
     * @return bool
     */
    public function hasDefinition(ContextDefinitionInterface $definition) : bool;

    /**
     * @param string $definitionId
     * @return bool
     */
    public function hasDefinitionId(string $definitionId) : bool;

    /**
     * @param string $definitionId
     * @return ContextDefinitionInterface
     */
    public function getDefinition(string $definitionId) : ContextDefinitionInterface;
}

