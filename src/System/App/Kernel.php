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
    use PowerEcommerce\System\Flow;
    use PowerEcommerce\System\Scheduler;

    class Kernel implements Flow
    {

        /** @type \PowerEcommerce\System\Scheduler ports */
        protected $_scheduler;

        /** @type \PowerEcommerce\System\App\SharedMemory */
        protected $_sharedMemory;

        /**
         * @param \PowerEcommerce\System\App\SharedMemory $sharedMemory
         * @param \PowerEcommerce\System\Scheduler        $scheduler
         */
        public function __construct(SharedMemory $sharedMemory = null, Scheduler $scheduler = null)
        {
            $this->_sharedMemory = (null === $sharedMemory ? new SharedMemory() : $sharedMemory);
            $this->_scheduler    = (null === $scheduler ? new Scheduler() : $scheduler);
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
         * @param string                                       $id
         * @param \PowerEcommerce\System\Scheduler\ItemWrapper $itemWrapper
         *
         * @return $this
         * @throws \PowerEcommerce\System\Scheduler\ItemAlreadyExistsException
         */
        public function add($id, $itemWrapper)
        {
            $this->scheduler()->add($id, $itemWrapper);
            return $this;
        }

        /**
         * @param string $id
         *
         * @return $this
         */
        public function del($id)
        {
            $this->scheduler()->del($id);
            return $this;
        }

        /**
         * @return $this
         */
        public function end()
        {
            $this->scheduler()->end();
            return $this;
        }

        /**
         * @return $this
         */
        public function execute()
        {
            $this->scheduler()->execute();
            return $this;
        }

        /**
         * @param string $id
         *
         * @return mixed
         */
        public function get($id)
        {
            return $this->scheduler()->get($id);
        }

        /**
         * @param string $id
         *
         * @return bool
         */
        public function has($id)
        {
            return $this->scheduler()->has($id);
        }

        /**
         * @return $this
         */
        public function load()
        {
            $this->scheduler()->load();
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
         * @param string                                       $id
         * @param \PowerEcommerce\System\Scheduler\ItemWrapper $itemWrapper
         *
         * @return $this
         */
        public function set($id, $itemWrapper)
        {
            $this->scheduler()->set($id, $itemWrapper);
            return $this;
        }

        /**
         * @param string $key
         * @param mixed  $value
         *
         * @return mixed|\PowerEcommerce\System\App\SharedMemory
         */
        public function sharedMemory($key = null, $value = null)
        {
            if (null !== $value) {
                $this->_sharedMemory->set($key, $value);
            }
            elseif (null !== $key) {
                return $this->_sharedMemory->get($key);
            }
            return $this->_sharedMemory;
        }
    }
}