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
namespace PowerEcommerce\App\PowerEcommerce\System\Thread {
    use PowerEcommerce\App\PowerEcommerce\System\Process\Request;
    use PowerEcommerce\Framework\Routing\Router as RouterComponent;
    use PowerEcommerce\Framework\Routing\Target;
    use PowerEcommerce\System\Thread;
    use PowerEcommerce\System\Thread\Priority;

    class Router extends Thread
    {

        /** @type int */
        protected $_priority = Priority::CRITICAL;

        /**
         * @return $this
         */
        public function abort()
        {
            return $this;
        }

        /**
         * @return $this
         */
        public function end()
        {
            return $this;
        }

        /**
         * @return $this
         */
        public function execute()
        {
            $target = $this->app()->sm('RouterTarget');
            $this->router()->handle($target);

            return $this;
        }

        /**
         * @return $this
         */
        public function load()
        {
            if (!$this->app()->sm('RouterTarget')) {
                $uri = (new Request())->uri();
                $this->app()->sm('RouterTarget', new Target($uri));
            }
            $this->psm('Router', new RouterComponent('powerecommerce.system.router'));
            return $this;
        }

        /**
         * @return \PowerEcommerce\Framework\Routing\Router
         */
        public function router()
        {
            return $this->psm()['Router'];
        }
    }
}