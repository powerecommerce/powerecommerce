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
    use PowerEcommerce\System\Linker\Context;
    use PowerEcommerce\System\Linker\Observer;
    use PowerEcommerce\System\Linker\PriorityQueue;

    class Linker
    {

        /** @type \PowerEcommerce\System\App */
        private $_app;

        /** @type \PowerEcommerce\System\Linker\Context */
        private $_context;

        /**
         * @param \PowerEcommerce\System\App $app
         */
        final public function __construct(App $app)
        {
            $this->_app     = $app;
            $this->_context = new Context();
        }

        /**
         * @return \PowerEcommerce\System\Linker\Context
         */
        final public function context()
        {
            return $this->_context;
        }

        /**
         * @param \PowerEcommerce\System\Linker\Observer $observer
         */
        final public function register(Observer $observer)
        {
            if (!$this->context()->has($observer->getEvent())) {
                $this->context()->set($observer->getEvent(), new PriorityQueue());
            }
            $this->context()->get($observer->getEvent())->insert($observer, $observer->getPriority());
        }
    }
}