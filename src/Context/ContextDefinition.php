<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\Context;

use Tidal\Behat\BaseExtension\Behavior\Context\ContextDefinitionTrait;
use Tidal\Behat\BaseExtension\Contract\Context\ContextDefinitionInterface;

/**
 * Class Tidal\Behat\BaseExtension\Context\ContextDefinition *
 */
class ContextDefinition implements ContextDefinitionInterface
{
    use ContextDefinitionTrait;
}
