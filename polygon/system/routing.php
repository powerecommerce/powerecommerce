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
require_once __DIR__ . '/../../vendor/autoload.php';

use PowerEcommerce\System\Routing\Component\Route;
use PowerEcommerce\System\Routing\Component\Router;
use PowerEcommerce\System\Routing\Component\Service;
use PowerEcommerce\System\Routing\Component\Target;

$target = new Target('/handle/');

$s1 = new Service('\PowerEcommerce\System\Routing\Component\Service', ['s1']);
$s2 = new Service('\PowerEcommerce\System\Routing\Component\Service', ['s2']);
$s3 = new Service('\PowerEcommerce\System\Routing\Component\Service', ['s3']);

$r1 = new Route('route/1');
$r1->attach($s1);

$r2 = new Route('route/2');

$router = new Router('router');
$router->attach($r1);
$router->attach($r2);

/* array (size=0)
    empty */
var_dump($router->handle($target)->getData());

$r3 = new Route('/?handle/?');
$r3->attach($s2);

$r4 = new Route('/?handle/?');
$r4->attach($s3);

$subRouter = new Router('sub/router');
$subRouter->attach($r3);
$subRouter->attach($r4);

$router->attach($subRouter);

/* array (size=2)
  0 =>
    object(PowerEcommerce\System\Routing\Component\Route)[9]
      protected '_data' =>
        array (size=2)
          'id' => string '/?handle/?' (length=10)
          0 =>
            object(PowerEcommerce\System\Routing\Component\Service)[4]
              private '_args' =>
                array (size=1)
                  0 => string 's2' (length=2)
              protected '_data' =>
                array (size=1)
                  'id' => string '\PowerEcommerce\System\Routing\Component\Service' (length=48)
              protected '_ptr' => int 0
      protected '_ptr' => int 0
  1 =>
    object(PowerEcommerce\System\Routing\Component\Route)[10]
      protected '_data' =>
        array (size=2)
          'id' => string '/?handle/?' (length=10)
          0 =>
            object(PowerEcommerce\System\Routing\Component\Service)[5]
              private '_args' =>
                array (size=1)
                  0 => string 's3' (length=2)
              protected '_data' =>
                array (size=1)
                  'id' => string '\PowerEcommerce\System\Routing\Component\Service' (length=48)
              protected '_ptr' => int 0
      protected '_ptr' => int 0
*/
var_dump($router->handle($target)->getData());