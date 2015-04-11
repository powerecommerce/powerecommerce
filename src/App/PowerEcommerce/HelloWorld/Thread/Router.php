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
namespace PowerEcommerce\App\PowerEcommerce\HelloWorld\Thread {
    use PowerEcommerce\Framework\Routing\Route;
    use PowerEcommerce\Framework\Routing\Thread as ThreadComponent;
    use PowerEcommerce\System\Thread;

    class Router extends Thread
    {
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
            return $this;
        }

        /**
         * @return $this
         */
        public function load()
        {
            $s1 = new ThreadComponent('\PowerEcommerce\App\PowerEcommerce\HelloWorld\Thread\Hello',
                                      '\PowerEcommerce\App\PowerEcommerce\System\Process\View');
            $r1 = (new Route('/?hello/?'))->attach($s1);

            $s2 = new ThreadComponent('\PowerEcommerce\App\PowerEcommerce\HelloWorld\Thread\World',
                                      '\PowerEcommerce\App\PowerEcommerce\System\Process\View');
            $r2 = (new Route('/?world/?'))->attach($s2);

            $this->psm()->getRouter()->attach($r1)->attach($r2);
            return $this;
        }
    }
}