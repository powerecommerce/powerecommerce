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
namespace PowerEcommerce\System\Routing\Component {
    use PowerEcommerce\System\Object;
    use PowerEcommerce\System\Routing\Component;

    class Router extends Component
    {
        public function __construct()
        {
            $this->set('components', new Object());
        }

        /**
         * @param \PowerEcommerce\System\Routing\Component $component
         *
         * @return $this
         */
        public function attach(Component $component)
        {
            !($component instanceof \PowerEcommerce\System\Routing\Component\Route) &&
            !($component instanceof \PowerEcommerce\System\Routing\Component\Router) && $this->invalid();

            $this->getComponents()->push($component);
            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Routing\Component $target
         *
         * @return \PowerEcommerce\System\Object
         */
        public function handle(Component $target)
        {
            /** @type \PowerEcommerce\System\Routing\Component\Target $target */
            !($target instanceof \PowerEcommerce\System\Routing\Component\Target) && $this->invalid();
            $collection = new Object();

            /** @type \PowerEcommerce\System\Routing\Component $route */
            foreach ($this->getComponents() as $route) {
                $pattern = '/' . addcslashes($route->getId(), '/') . '/' . $route->getModifiers();

                if ((preg_match($pattern, $target->getId())) ||
                    ($route instanceof \PowerEcommerce\System\Routing\Component\Router)
                ) {
                    $collection->pushData($route->handle($target)->getData());
                }
            }
            return $collection;
        }
    }
}