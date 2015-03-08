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
namespace PowerEcommerce\System\App {
    use PowerEcommerce\System\Object;

    abstract class Facade extends Object
    {

        /** @type \PowerEcommerce\App\App */
        public $app;

        /**
         * @param $service
         *
         * @return callable
         */
        protected function _register($service)
        {
            return function () use ($service) {
                static $_service;

                if (null === $_service) {
                    $_service = $service;
                }
                if (is_object($_service)) {
                    /** @type \PowerEcommerce\System\Service $_service */
                    if ($_service->status === $_service::STOP) {
                        $_service->start();
                    }
                    return $_service;
                }
                else {
                    /** @type \PowerEcommerce\System\Service $_service */
                    $_service = new $_service($this->app);
                    return $_service->start();
                }
            };
        }
    }
}