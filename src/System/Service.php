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

        const START = 1;

        const STOP  = 2;

        /** @type \PowerEcommerce\App\App */
        private $_app;

        /** @type callable */
        private $_call = null;

        /** @type callable */
        private $_gc = null;

        /** @type callable */
        private $_init = null;

        /** @type int */
        public $status;

        /**
         * @param \PowerEcommerce\App\App $app
         */
        final public function __construct(\PowerEcommerce\App\App $app)
        {
            $this->_app   = $app;
            $this->status = self::STOP;
        }

        /**
         * @return mixed
         */
        final public function __invoke()
        {
            null === $this->_call && $this->start();
            $virtual = $this->_call;

            return $virtual();
        }

        abstract protected function _call();

        abstract protected function _gc();

        abstract protected function _init();

        /**
         * @return array
         */
        final public static function after()
        {
            return [1, md5(get_called_class())];
        }

        /**
         * @return array
         */
        final public static function before()
        {
            return [-1, md5(get_called_class())];
        }

        /**
         * @return mixed
         */
        final public function call()
        {
            return $this->__invoke();
        }

        /**
         * @return \PowerEcommerce\App\App
         */
        final public function getApp()
        {
            return $this->_app;
        }

        /**
         * @param callable $_call
         * @param callable $_init
         * @param callable $_gc
         *
         * @return $this
         *
         */
        final public function override(callable $_call, callable $_init, callable $_gc)
        {
            null !== $_call && $this->_call = $_call;
            null !== $_init && $this->_init = $_init;
            null !== $_gc && $this->_gc = $_gc;

            return $this;
        }

        /**
         * @return $this
         */
        final public function restart()
        {
            $this->stop();
            return $this->start();
        }

        /**
         * @return $this
         */
        final public function start()
        {
            if (null === $this->getApp()->getDisableServiceStart()) {
                if (null === $this->_call) {
                    $this->_call = function () { return $this->_call(); };
                }
                if (null === $this->_init) {
                    $this->_init = function () { return $this->_init(); };
                }
                $virtual = $this->_init;
                $virtual();

                $this->status = self::START;
            }
            return $this;
        }

        /**
         * @return $this
         */
        final public function stop()
        {
            if (null === $this->getApp()->getDisableServiceStop()) {
                if (null === $this->_gc) {
                    $this->_gc = function () { return $this->_gc(); };
                }
                $virtual = $this->_gc;
                $virtual();

                $this->status = self::STOP;
            }
            return $this;
        }
    }
}