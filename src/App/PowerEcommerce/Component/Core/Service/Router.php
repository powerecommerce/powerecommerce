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
        private $_model;

        protected function _call()
        {
            $target     = $this->getApp()->getRouterTarget();
            $collection = $this->getModel()->handle($target);

            $this->getApp()->setRouteCollection($collection);
        }

        protected function _gc() { }

        protected function _init()
        {
            if (!$this->getApp()->hasRouterTarget()) {
                $uri = $this->getApp()->PowerEcommerce->Core->Request()->getUri();
                $this->getApp()->setRouterTarget(new Target($uri));
            }
            $this->_model = new \PowerEcommerce\System\Routing\Component\Router();
        }

        /**
         * @return \PowerEcommerce\System\Routing\Component\Router
         */
        public function getModel()
        {
            return $this->_model;
        }
    }
}