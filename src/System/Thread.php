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
    use PowerEcommerce\App;
    use PowerEcommerce\System\Process\Shared\Memory;
    use PowerEcommerce\System\Thread\Priority;

    abstract class Thread implements Flow
    {

        /** @type \PowerEcommerce\App */
        protected $_app;

        /** @type int */
        protected $_priority = Priority::NORMAL;

        /** @type \PowerEcommerce\System\Process\Shared\Memory */
        protected $_psm;

        public function __construct(Memory $psm)
        {
            $this->_psm = $psm;
            $this->_app = App::singleton();
        }

        /**
         * @return \PowerEcommerce\App
         */
        public function app()
        {
            return $this->_app;
        }

        /**
         * @return string
         */
        public function getCalledClass()
        {
            return '\\' . get_called_class();
        }

        /**
         * @return int
         */
        public function getPriority()
        {
            return $this->_priority;
        }

        /**
         * @param string $key
         * @param mixed  $value
         *
         * @return mixed|\PowerEcommerce\System\Process\Shared\Memory
         */
        public function psm($key = null, $value = null)
        {
            if (null !== $value) {
                $this->_psm->set($key, $value);
            }
            elseif (null !== $key) {
                return $this->_psm->get($key);
            }
            return $this->_psm;
        }

        /**
         * @param int $priority
         *
         * @return int
         */
        public function setPriority($priority)
        {
            if (null !== $priority) {
                $this->_priority = $priority;
            }
            return $this;
        }
    }
}