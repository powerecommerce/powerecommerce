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
    use PowerEcommerce\System\App\Context;
    use PowerEcommerce\System\Boot\Loader;

    class App
    {

        /** @type \PowerEcommerce\System\Broker */
        protected $_broker;

        /** @type \PowerEcommerce\System\App\Context */
        protected $_context;

        /** @type \PowerEcommerce\System\Linker */
        protected $_linker;

        /** @type \PowerEcommerce\System\Boot\Loader */
        protected $_loader;

        public function __construct(Context $context)
        {
            $this->_context = $context;
            $this->_loader  = new Loader($this);
            $this->_broker  = new Broker($this);
            $this->_linker  = new Linker($this);
        }

        /**
         * @return \PowerEcommerce\System\Broker
         */
        final public function broker()
        {
            return $this->_broker;
        }

        /**
         * @return \PowerEcommerce\System\App\Context
         */
        final public function context()
        {
            return $this->_context;
        }

        /**
         * @return $this
         */
        public function down()
        {
            $this->_broker->down();
            $this->_loader->down();

            return $this;
        }

        /**
         * @return \PowerEcommerce\System\Linker
         */
        final public function linker()
        {
            return $this->_linker;
        }

        /**
         * @return $this
         */
        public function render()
        {
            return $this;
        }

        /**
         * @return $this
         */
        public function up()
        {
            $this->_loader->up();
            $this->_broker->up();

            return $this;
        }
    }
}