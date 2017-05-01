<?php
/**
 * This file is part of the behat-base-extension package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$runner->addTestsFromDirectory(__DIR__ . '/tests/units');
$script->addDefaultReport();
$xunitWriter = new \atoum\writers\file(__DIR__ . '/tests/reports/atoum.xunit.xml');
$xunitReport = new \atoum\reports\asynchronous\xunit();
$xunitReport->addWriter($xunitWriter);
$runner->addReport($xunitReport);