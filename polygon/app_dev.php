<?php

/**
 * Copyright (c) 2015 Tomasz Duda
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
require_once __DIR__ . '/../vendor/autoload.php';

use PowerEcommerce\System\App;
use PowerEcommerce\System\Flow\Priority;
use PowerEcommerce\System\Port\Scheduler\ItemWrapper as PortWrapper;
use PowerEcommerce\System\Scheduler\ItemWrapper;

$app       = App::singleton();
$scheduler = $app->scheduler();

$app->sharedMemory('DS', DIRECTORY_SEPARATOR);
$app->sharedMemory('BaseDir', realpath(__DIR__ . $app->sharedMemory('DS') . '..'));
$app->sharedMemory('BootLoaderDir', $app->sharedMemory('BaseDir') . $app->sharedMemory('DS') . 'boot');

$bootPortId     = 'PowerEcommerceBootPort';
$bootProcessId  = 'PowerEcommerceBootProcess';
$bootProcessSrc = '\PowerEcommerce\App\PowerEcommerce\System\Process\Boot';
$bootThreadId   = 'PowerEcommerceBootThread';
$bootThreadSrc  = '\PowerEcommerce\App\PowerEcommerce\System\Thread\Boot';

$scheduler->set($bootPortId, new PortWrapper(Priority::CRITICAL));

/** @type \PowerEcommerce\System\Scheduler\ItemWrapper $port */
$port = $scheduler->get($bootPortId);
$port->set($bootProcessId, new ItemWrapper($bootProcessSrc, Priority::CRITICAL));

/** @type \PowerEcommerce\System\Scheduler\ItemWrapper $process */
$process = $port->get($bootProcessId);
$process->set($bootThreadId, new ItemWrapper($bootThreadSrc, Priority::CRITICAL));

$app->run();