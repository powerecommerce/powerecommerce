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
namespace PowerEcommerce\System\Linker {
    use PowerEcommerce\System\App;
    use PowerEcommerce\System\Service\Context;

    class Observer
    {

        /** @type string */
        private $_event;

        /** @type int */
        private $_priority;

        /** @type \PowerEcommerce\System\Service */
        private $_service = null;

        /** @type string */
        private $_target;

        /**
         * @param string $event
         * @param string $target
         * @param int    $priority
         */
        final public function __construct($event, $target, $priority = 0)
        {
            $this->setEvent($event);
            $this->setTarget($target);
            $this->setPriority($priority);
        }

        /**
         * @return string
         */
        final public function getEvent()
        {
            return $this->_event;
        }

        /**
         * @return int
         */
        final public function getPriority()
        {
            return $this->_priority;
        }

        /**
         * @return string
         */
        final public function getTarget()
        {
            return $this->_target;
        }

        /**
         * @param \PowerEcommerce\System\App             $app
         * @param \PowerEcommerce\System\Service\Context $context
         *
         * @return $this
         */
        final public function notify(App $app, Context $context)
        {
            if (null === $this->_service) {
                /** @type \PowerEcommerce\System\Service $service */
                $service        = $this->_target;
                $this->_service = $service::observer($app);
            }
            $this->_service->notify($app, $context, $this);
        }

        /**
         * @param string $event
         */
        final public function setEvent($event)
        {
            $this->_event = $event;
        }

        /**
         * @param int $priority
         */
        final public function setPriority($priority)
        {
            $this->_priority = $priority;
        }

        /**
         * @param string $target
         */
        final public function setTarget($target)
        {
            $this->_target = $target;
        }
    }
}