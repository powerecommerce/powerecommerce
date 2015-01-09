<?php

/**
 * Copyright (c) 2015 DD Art Tomasz Duda
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
    use PowerEcommerce\System\Data\Argument;
    use PowerEcommerce\System\Data\Collection;
    use PowerEcommerce\System\Data\RegExp;
    use PowerEcommerce\System\Routing\Component;
    use PowerEcommerce\System\TypeCode;

    /**
     * Class Router
     *
     * <code><?php
     *
     * $handle = new \PowerEcommerce\System\Routing\Component\Handle('/handle/');
     *
     * $s1 = new \PowerEcommerce\System\Routing\Component\Service('\PowerEcommerce\System\Routing\Component\Service', ['s1']);
     *
     * $r1 = new \PowerEcommerce\System\Routing\Component\Route(
     * new \PowerEcommerce\System\Data\RegExp('=route/1='));
     * $r1->attach($s1);
     *
     * $r2 = new \PowerEcommerce\System\Routing\Component\Route(
     * new \PowerEcommerce\System\Data\RegExp('=route/2='));
     *
     * $router = new \PowerEcommerce\System\Routing\Component\Router('router');
     * $router->attach($r1);
     * $router->attach($r2);
     *
     * var_dump($router->handle($handle)); //empty route
     *
     * $r3 = new \PowerEcommerce\System\Routing\Component\Route(
     * new \PowerEcommerce\System\Data\RegExp('=/?handle/?='));
     * $router->attach($r3->attach($s1));
     *
     * var_dump($router->handle($handle)); //route 3
     *
     * ?></code>
     *
     * @package PowerEcommerce\System\Routing\Component
     */
    class Router extends Component
    {
        /**
         * @var \PowerEcommerce\System\Data\Collection
         */
        private $children;

        /**
         * @param string|\PowerEcommerce\System\Data\String $name
         */
        function __construct($name)
        {
            $this->children = new Collection();
            parent::__construct($name);
        }

        /**
         * @param \PowerEcommerce\System\Routing\Component $component
         * @return $this
         */
        function attach(Component $component)
        {
            (new Argument($component))->strict(TypeCode::ROUTE);
            $this->children->add((string)$component, $component, 'This route already exists');

            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Routing\Component $component
         * @return $this
         */
        function detach(Component $component)
        {
            (new Argument($component))->strict(TypeCode::ROUTE);
            $this->children->del((string)$component);

            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Routing\Component $component
         * @return \PowerEcommerce\System\Routing\Component\Route
         */
        function handle(Component $component)
        {
            (new Argument($component))->strict(TypeCode::HANDLE);
            $_route = new Route(new RegExp());

            /** @var \PowerEcommerce\System\Routing\Component\Route $route */
            foreach ($this->children as $route) {
                /** @var \PowerEcommerce\System\Routing\Component\Handle $component */
                if ($component->handle($route)) return $route->handle($component);
            }

            return $_route;
        }

        /**
         * @return int TypeCode
         */
        function getTypeCode()
        {
            return TypeCode::ROUTER;
        }
    }
}
