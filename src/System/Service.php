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
namespace PowerEcommerce\System {
    abstract class Service extends Object
    {
        /**
         * @type callable
         */
        private $_execute = null;

        /**
         * @type callable
         */
        private $_gc = null;

        /**
         * @type callable
         */
        private $_init = null;

        /**
         * @type \PowerEcommerce\App\App
         */
        protected $app;

        /**
         * @param \PowerEcommerce\App\App $app
         */
        final public function __construct(\PowerEcommerce\App\App $app)
        {
            $this->app = $app;
        }

        /**
         * @return mixed
         */
        final public function __invoke()
        {
            null === $this->_execute && $this->start();
            $virtual = $this->_execute;

            return $virtual();
        }

        abstract protected function _call();

        abstract protected function _gc();

        abstract protected function _init();

        /**
         * @return mixed
         */
        final public function call()
        {
            return $this->__invoke();
        }

        /**
         * @param callable $_execute
         * @param callable $_init
         * @param callable $_gc
         *
         * @return $this
         *
         */
        final public function override(callable $_execute, callable $_init, callable $_gc)
        {
            null !== $_execute && $this->_execute = $_execute;
            null !== $_init && $this->_init = $_init;
            null !== $_gc && $this->_gc = $_gc;

            return $this;
        }

        final public function restart()
        {
            $this->stop();
            $this->start();
        }

        /**
         * @return $this
         */
        final public function start()
        {
            if (null === $this->_execute) {
                $this->_execute = function () { return $this->_call(); };
            }
            if (null === $this->_init) {
                $this->_init = function () { return $this->_init(); };
            }
            $virtual = $this->_init;
            $virtual();

            return $this;
        }

        /**
         * @return $this
         */
        final public function stop()
        {
            if (null === $this->_gc) {
                $this->_gc = function () { return $this->_gc(); };
            }
            $virtual = $this->_gc;
            $virtual();

            return $this;
        }
    }
}