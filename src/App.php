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
namespace PowerEcommerce {
    use PowerEcommerce\System\Kernel;
    use PowerEcommerce\System\Scheduler;
    use PowerEcommerce\System\Shared\Memory;
    use PowerEcommerce\System\Util\Singleton;

    class App
    {
        use Singleton;

        /** @type \PowerEcommerce\System\Kernel */
        protected $_kernel;

        /** @type \PowerEcommerce\System\Shared\Memory */
        protected $_sm;

        protected function __construct()
        {
            $this->_sm     = new Memory();
            $this->_kernel = new Kernel(new Memory(), new Scheduler());
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
         * @return \PowerEcommerce\System\Kernel
         */
        public function kernel()
        {
            return $this->_kernel;
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
         * @param string $key
         * @param mixed  $value
         *
         * @return mixed|\PowerEcommerce\System\Shared\Memory
         */
        public function sm($key = null, $value = null)
        {
            if (null !== $value) {
                $this->_sm->set($key, $value);
            }
            elseif (null !== $key) {
                return $this->_sm->get($key);
            }
            return $this->_sm;
        }
    }
}