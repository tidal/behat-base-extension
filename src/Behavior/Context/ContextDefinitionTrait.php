<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\Behavior\Context;

use Tidal\Behat\BaseExtension\Context\ContextDefinitionException;
use Tidal\Behat\BaseExtension\Contract\Context\ContextDefinitionInterface;

use Behat\Behat\Context\Context;

/**
 * Trait Tidal\Behat\BaseExtension\Behavior\Context\ContextDefinitionTrait *
 */
trait ContextDefinitionTrait
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $namespace = '';

    /**
     * @var string
     */
    protected $id = '';

    /**
     * @var string
     */
    protected $contextClass = '';

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;

        $this->generateId();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace(string $namespace)
    {
        $this->namespace = $namespace;

        $this->generateId();
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        if (!isset($this->id) || trim($this->id) === '') {
            $this->generateId();
        }

        return $this->id;
    }

    /**
     * @param string $contextClass
     */
    public function setClass(string $contextClass)
    {
        $this->validateContextClass($contextClass);

        $this->contextClass = $contextClass;
    }

    /**
     * @return string
     */
    public function getClass() : string
    {
        return $this->contextClass;
    }

    private function generateId()
    {
        $this->id =
            $this->getNamespace().
            $this->getName();
    }

    /**
     * @param $contextClass
     * @throws ContextDefinitionException
     */
    private function validateContextClass($contextClass)
    {
        if (!class_exists($contextClass)) {
            throw new ContextDefinitionException(
                sprintf(
                    "class '%s' does not exist",
                    $contextClass
                )
            );
        }

        if (!in_array(Context::class, class_implements($contextClass))) {
            throw new ContextDefinitionException(
                sprintf(
                    "class '%s' does not implement '%s'",
                    $contextClass,
                    Context::class
                )
            );
        }
    }
}

