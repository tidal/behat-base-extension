<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\Contract\Context;

/**
 * Interface Tidal\Behat\BaseExtension\Contract\Context\ContextDefinitionInterface *
 */
interface ContextDefinitionInterface
{
    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @return string
     */
    public function getNamespace() : string;

    /**
     * @return string
     */
    public function getId() : string;

    /**
     * @return string
     */
    public function getClass() : string;
}
