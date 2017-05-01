<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
require_once  __DIR__.'/vendor/autoload.php';

$reportsDir = 'tests/reports';

if(!is_dir($reportsDir)) {
    mkdir($reportsDir);
}