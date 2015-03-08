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
    use PowerEcommerce\System\Routing\Component\Target;
    use PowerEcommerce\System\Service;

    class Router extends Service
    {

        /** @type \PowerEcommerce\System\Routing\Component\Router */
        public $model;

        protected function _call()
        {
            $this->app->set('route_collection', $this->model->handle($this->app->get('router_target')));
            if ($this->app->get('route_collection') instanceof \Traversable) {

                /** @type \PowerEcommerce\System\Routing\Component\Route $route */
                foreach ($this->app->get('route_collection') as $route) {

                    /** @type \PowerEcommerce\System\Routing\Component\Service $service */
                    foreach ($route->getComponents() as $service) {
                        $service->getService()->call();
                    };
                }
                foreach ($this->app->get('route_collection') as $route) {
                    foreach ($route->getComponents() as $service) {
                        $service->getService()->stop();
                    };
                }
            }
        }

        protected function _gc() { }

        protected function _init()
        {
            if (!$this->app->has('router_target')) {
                $this->app->set('router_target', new Target($_SERVER['REQUEST_URI']));
            }
            $this->model = new \PowerEcommerce\System\Routing\Component\Router();
        }
    }
}