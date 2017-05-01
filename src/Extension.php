<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\Behat\BaseExtension;

use Tidal\Behat\BaseExtension\Behavior\ExtensionTrait;
use Tidal\Behat\BaseExtension\Contract\ExtensionInterface;

/**
 * Class Tidal\Behat\BaseExtension\Extension
 */
class Extension implements ExtensionInterface
{
   use ExtensionTrait;
}

