<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\Contract\Context\ContextClass;


use Behat\Behat\Context\ContextClass\ClassResolver as BaseInterface;

/**
 * Interface Tidal\Behat\BaseExtension\Contract\Context\ContextClass\ClassResolverInterface *
 */
interface ClassResolverInterface extends BaseInterface
{
    /**
     * @param string $contextNamespace
     */
    public function setContextNamespace(string $contextNamespace);

    /**
     * @return string
     */
    public function getContextNamespace(): string;

    /**
     * @param string $alias
     */
    public function addContextAlias(string $alias);

    /**
     * @param string $alias
     * @return bool
     */
    public function hasContextAlias(string $alias);

    /**
     * @return array
     */
    public function getContextAliases(): array;

    /**
     * @param string $alias
     */
    public function removeContextAlias(string $alias);
}
