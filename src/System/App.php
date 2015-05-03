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
    use PowerEcommerce\System\App\Kernel;
    use PowerEcommerce\System\Scheduler;
    use PowerEcommerce\System\Util\Singleton;

    class App implements Flow
    {
        use Singleton;

        /** @type \PowerEcommerce\System\App\Kernel */
        protected $_kernel;

        /**
         * @param \PowerEcommerce\System\App\Kernel $kernel
         */
        protected function __construct(Kernel $kernel = null)
        {
            $this->_kernel = (null === $kernel ? new Kernel() : $kernel);
        }

        /**
         * @return $this
         */
        public function abort()
        {
            $this->kernel()->abort();
            return $this;
        }

        /**
         * @return $this
         */
        public function end()
        {
            $this->kernel()->end();
            return $this;
        }

        /**
         * @return $this
         */
        public function execute()
        {
            $this->kernel()->execute();
            return $this;
        }

        /**
         * @return \PowerEcommerce\System\App\Kernel
         */
        public function kernel()
        {
            return $this->_kernel;
        }

        /**
         * @return $this
         */
        public function load()
        {
            $this->kernel()->load();
            return $this;
        }

        /**
         * @return $this
         */
        public function run()
        {
            $this->kernel()->run();
            return $this;
        }

        /**
         * @return \PowerEcommerce\System\Scheduler
         */
        public function scheduler()
        {
            return $this->kernel()->scheduler();
        }

        /**
         * @param string $key
         * @param mixed  $value
         *
         * @return mixed|\PowerEcommerce\System\App\SharedMemory
         */
        public function sharedMemory($key = null, $value = null)
        {
            return $this->kernel()->sharedMemory($key, $value);
        }
    }
}