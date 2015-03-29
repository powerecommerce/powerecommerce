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
namespace PowerEcommerce\App\PowerEcommerce\Core\Service {
    use PowerEcommerce\System\Object;
    use PowerEcommerce\System\Routing\Component\Target;
    use PowerEcommerce\System\Service;

    class Router extends Service
    {
        public function _init()
        {
            if (!$this->app()->context()->hasRouterTarget()) {
                $uri = Request::singleton($this->app())->getUri();
                $this->app()->context()->setRouterTarget(new Target($uri));
            }
            $this->context()->setRouter(new \PowerEcommerce\System\Routing\Component\Router());
        }

        public function _start()
        {
            $target     = $this->app()->context()->getRouterTarget();
            $collection = $this->router()->handle($target);

            /** @type \PowerEcommerce\System\Routing\Component\Service $service */
            foreach ($collection as $service) {
                /** @type \PowerEcommerce\System\Service $handler */
                if (is_object($service)) {
                    $handler = $service->getData()[0]->getServiceHandler();
                    $this->app()->broker()->register($handler::factory($this->app()));
                }
            }
        }

        public function _stop() { }

        /**
         * @return \PowerEcommerce\System\Routing\Component\Router
         */
        public function router()
        {
            return $this->context()['Router'];
        }
    }
}