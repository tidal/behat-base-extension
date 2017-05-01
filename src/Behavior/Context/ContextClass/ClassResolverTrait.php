<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\Behavior\Context\ContextClass;

/**
 * trait Tidal\Behat\BaseExtension\Behavior\Context\ContextClass\ClassResolverTrait *
 */
trait ClassResolverTrait
{
    /**
     * @var string
     */
    protected $contextNamespace = '';

    /**
     * @var array
     */
    protected $contextAliases = [

    ];

    /**
     * Checks if resolvers supports provided class.
     *
     * @param string $contextClass
     *
     * @return Boolean
     */
    public function supportsClass($contextClass)
    {
        return $this->supportsContext($contextClass);
    }

    /**
     * Resolves context class.
     *
     * @param string $contextClass
     *
     * @return string
     */
    abstract public function resolveClass($contextClass);

    /**
     * @param string $contextNamespace
     */
    public function setContextNamespace(string $contextNamespace)
    {
        if (!$this->hasContextNamespace()) {
            $this->contextNamespace = $contextNamespace;
        }
    }

    /**
     * @return string
     */
    public function getContextNamespace(): string
    {
        return $this->contextNamespace;
    }

    /**
     * @param string $alias
     */
    public function addContextAlias(string $alias)
    {
        $this->contextAliases[$alias] = true;
    }

    /**
     * @param string $alias
     * @return bool
     */
    public function hasContextAlias(string $alias)
    {
        return isset($this->contextAliases[$alias])
                && $this->contextAliases[$alias] === true;
    }

    /**
     * @return array
     */
    public function getContextAliases(): array
    {
        return array_keys($this->contextAliases);
    }

    /**
     * @param string $alias
     */
    public function removeContextAlias(string $alias)
    {
        if ($this->hasContextAlias($alias)) {
            unset($this->contextAliases[$alias]);
        }
    }

    /**
     * @param string $contextClass
     * @return bool
     */
    public function supportsContextNamespace(string $contextClass)
    {
        return $this->getContextNamespace() === ''
            || strpos($contextClass, $this->getContextNamespace()) === 0;
    }

    /**
     * @param string $contextClass
     * @return bool
     */
    protected function supportsContext(string $contextClass)
    {
        return $this->supportsContextNamespace($contextClass)
            && $this->hasContextAlias(
                $this->extractAliasFromContextClass($contextClass)
            );
    }

    /**
     * @param string $contextClass
     * @return mixed
     */
    protected function extractAliasFromContextClass(string $contextClass)
    {
        return str_replace(
            $this->getContextNamespace(),
            '',
            $contextClass
        );
    }

    protected function hasContextNamespace()
    {
        return trim($this->getContextNamespace()) !== '';
    }
}

