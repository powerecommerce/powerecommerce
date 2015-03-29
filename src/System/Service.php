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
    use PowerEcommerce\System\Linker\Observer;
    use PowerEcommerce\System\Service\Context;
    use PowerEcommerce\System\Service\Event;
    use PowerEcommerce\System\Service\Priority;
    use PowerEcommerce\System\Service\Status;

    abstract class Service
    {

        /** @type \PowerEcommerce\System\App */
        protected $_app;

        /** @type \PowerEcommerce\System\Service\Context */
        protected $_context;

        /** @type int */
        public $priority = Priority::MAIN;

        /** @type int */
        public $status = Status::UNDEFINED;

        final protected function __construct(App $app)
        {
            $this->_app     = $app;
            $this->_context = new Context();
        }

        final protected function __clone() { }

        /**
         * @return $this
         */
        final public function __invoke()
        {
            Status::START !== $this->status && $this->start();
            return $this;
        }

        abstract public function _init();

        abstract public function _start();

        abstract public function _stop();

        /**
         * @return \PowerEcommerce\System\App
         */
        final public function app()
        {
            return $this->_app;
        }

        /**
         * @return \PowerEcommerce\System\Service\Context
         */
        final public function context()
        {
            return $this->_context;
        }

        /**
         * @param \PowerEcommerce\System\App $app
         *
         * @return $this
         */
        final public static function factory(App $app)
        {
            $service = new static($app);

            $service->fire(Event::INIT_BEFORE);
            $service->fire(get_called_class() . '\Init\Before');

            $service->status = Status::INIT;
            $service->_init();

            $service->fire(Event::INIT_AFTER);
            $service->fire(get_called_class() . '\Init\After');

            return $service;
        }

        /**
         * @param string $event
         *
         * @return $this
         */
        final public function fire($event)
        {
            $context = $this->app()->linker()->context();

            if ($context->has($event)) {
                /** @type \PowerEcommerce\System\Linker\Observer $observer */
                foreach (clone $context->get($event) as $observer) {
                    $observer->notify($this->app(), $this->context());
                }
            }
            return $this;
        }

        /**
         * @param \PowerEcommerce\System\App             $app
         * @param \PowerEcommerce\System\Service\Context $context
         * @param \PowerEcommerce\System\Linker\Observer $observer
         *
         * @return $this
         */
        public function notify(App $app, Context $context, Observer $observer)
        {
            return $this;
        }

        /**
         * @param \PowerEcommerce\System\App $app
         *
         * @return $this
         */
        final public static function observer(App $app)
        {
            $service = new static($app);

            $service->status = Status::OBSERVER;
            $service->_init();

            return $service;
        }

        /**
         * @return int
         */
        final public function priority()
        {
            return $this->priority;
        }

        /**
         * @return $this
         */
        final public function restart()
        {
            $this->stop();
            return $this->start();
        }

        /**
         * @param \PowerEcommerce\System\App $app
         *
         * @return $this
         */
        final public static function singleton(App $app)
        {
            static $instance;

            if (null === $instance) {
                $instance = static::factory($app);
            }
            return $instance;
        }

        /**
         * @return $this
         */
        final public function start()
        {
            if (Status::START !== $this->status) {
                $this->fire(Event::START_BEFORE);
                $this->fire(get_called_class() . '\Start\Before');

                $this->status = Status::START;
                $this->_start();

                $this->fire(Event::START_AFTER);
                $this->fire(get_called_class() . '\Start\After');
            }
            return $this;
        }

        /**
         * @return int
         */
        final public function status()
        {
            return $this->status;
        }

        /**
         * @return $this
         */
        final public function stop()
        {
            if (Status::STOP !== $this->status) {
                $this->fire(Event::STOP_BEFORE);
                $this->fire(get_called_class() . '\Stop\Before');

                $this->status = Status::STOP;
                $this->_stop();

                $this->fire(Event::STOP_AFTER);
                $this->fire(get_called_class() . '\Stop\After');
            }
            return $this;
        }
    }
}