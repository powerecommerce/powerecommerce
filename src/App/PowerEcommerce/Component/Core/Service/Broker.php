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
namespace PowerEcommerce\App\PowerEcommerce\Component\Core\Service {
    use PowerEcommerce\System\Object;
    use PowerEcommerce\System\Service;

    class Broker extends Service
    {
        protected function _call()
        {
            if ($this->getApp()->hasRouteCollection()) {
                $serviceCollection = new Object();

                $this->getApp()->setDisableServiceStart(true);

                /** @type \PowerEcommerce\System\Routing\Component\Route $route */
                foreach ($this->getApp()->getRouteCollection() as $route) {
                    $serviceCollection->pushData($route->getComponents()->getData());
                }

                /** @type \PowerEcommerce\System\Routing\Component\Service $service */
                foreach ($serviceCollection as $key => $service) {
                    $handler = $service->getServiceHandler();
                    $serviceCollection->set($key, $handler());
                }

                $this->getApp()->delDisableServiceStart();

                /** @type \PowerEcommerce\System\Service $service */
                foreach ($serviceCollection as $key => $service) {
                    $service->start();
                }
                foreach ($serviceCollection as $key => $service) {
                    $service->call();
                }
                foreach ($serviceCollection as $key => $service) {
                    $service->stop();
                }
            }
        }

        protected function _gc() { }

        protected function _init() { }
    }
}