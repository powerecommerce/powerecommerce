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
    use PowerEcommerce\System\Shared\Memory;

    class Kernel
    {

        /** @type \PowerEcommerce\System\Scheduler */
        protected $_scheduler;

        /** @type \PowerEcommerce\System\Shared\Memory */
        protected $_sm;

        public function __construct(Memory $sm, Scheduler $scheduler)
        {
            $this->_sm        = $sm;
            $this->_scheduler = $scheduler;
        }

        /**
         * @return $this
         */
        public function abort()
        {
            $this->scheduler()->abort();
            return $this;
        }

        /**
         * @return $this
         */
        public function run()
        {
            $this->scheduler()->run();
            return $this;
        }

        /**
         * @return \PowerEcommerce\System\Scheduler
         */
        public function scheduler()
        {
            return $this->_scheduler;
        }

        /**
         * @return \PowerEcommerce\System\Shared\Memory
         */
        public function sm()
        {
            return $this->_sm;
        }
    }
}