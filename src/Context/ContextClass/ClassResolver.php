<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension\Context\ContextClass;

use Tidal\Behat\BaseExtension\Behavior\Context\ContextClass\IdentifiableContextResolverTrait as ResolverTrait;
use Tidal\Behat\BaseExtension\Contract\Context\ContextClass\IdentifiableContextResolverInterface as ResolverInterface;

/**
 * Class Tidal\Behat\BaseExtension\Context\ContextClass\ClassResolver
 */
class ClassResolver implements ResolverInterface
{
    use ResolverTrait;
}

