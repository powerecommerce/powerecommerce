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
    use PowerEcommerce\System\Scheduler\PriorityQueue;

    class Scheduler
    {

        /** @type \PowerEcommerce\System\Object */
        protected $_data;

        /** @type \PowerEcommerce\System\Scheduler\PriorityQueue */
        protected $_queue;

        public function __construct()
        {
            $this->_data  = new Object();
            $this->_queue = new PriorityQueue();
        }

        /**
         * @return $this
         */
        public function abort()
        {
            foreach ($this->queue() as $portId) {
                $this->port($portId)->abort();
            }
            return $this;
        }

        /**
         * @param string $id
         * @param int    $priority
         *
         * @return $this
         */
        public function createPort($id, $priority = null)
        {
            if (!$this->_data->has($id)) {
                $this->_data->set($id, new Port);
                $this->queue()->insert($id, $priority);
            }
            return $this;
        }

        /**
         * @param string $id
         * @param int    $priority
         *
         * @return \PowerEcommerce\System\Port
         */
        public function port($id, $priority = null)
        {
            if (!$this->_data->has($id)) {
                $this->createPort($id, $priority);
            }
            return $this->_data->get($id);
        }

        /**
         * @return \PowerEcommerce\System\Scheduler\PriorityQueue
         */
        public function queue()
        {
            return $this->_queue;
        }

        public function run()
        {
            foreach ($this->queue() as $portId) {
                $this->port($portId)->load()->execute()->end();
            }
            $this->queue()->count() && $this->run();
        }
    }
}