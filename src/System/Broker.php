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
    use PowerEcommerce\System\Broker\PriorityQueue;

    class Broker
    {

        /** @type \PowerEcommerce\System\App */
        private $_app;

        /** @type \PowerEcommerce\System\Broker\PriorityQueue */
        private $_queue;

        /**
         * @param \PowerEcommerce\System\App $app
         */
        final public function __construct(App $app)
        {
            $this->_app   = $app;
            $this->_queue = new PriorityQueue();
        }

        /**
         * @return \PowerEcommerce\System\App
         */
        final public function app()
        {
            return $this->_app;
        }

        /**
         * @return $this
         */
        final public function down()
        {
            /** @type \PowerEcommerce\System\Service $service */
            foreach (clone $this->queue() as $service) {
                $service->stop();
            }
            return $this;
        }

        /**
         * @return \PowerEcommerce\System\Broker\PriorityQueue
         */
        final public function queue()
        {
            return $this->_queue;
        }

        /**
         * @param \PowerEcommerce\System\Service
         */
        final public function register(Service $service)
        {
            $this->queue()->insert($service, $service->priority());
        }

        /**
         * @return $this
         */
        final public function up()
        {
            /** @type \PowerEcommerce\System\Service $service */
            foreach (clone $this->queue() as $service) {
                $service->start();
            }
            return $this;
        }
    }
}