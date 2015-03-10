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
namespace PowerEcommerce\System\Routing\Component {
    use PowerEcommerce\System\App;
    use PowerEcommerce\System\Routing\Component;

    /**
     * @method callable getServiceHandler()
     */
    class Service extends Component
    {
        /**
         * @param callable $service
         */
        public function __construct(callable $service)
        {
            $this->set('service/handler', $service);
        }

        /**
         * @param \PowerEcommerce\System\Routing\Component $component
         *
         * @return $this
         */
        public function attach(Component $component)
        {
            $this->invalid();
        }

        /**
         * @param \PowerEcommerce\System\Routing\Component $component
         *
         * @return \PowerEcommerce\System\Object
         */
        public function handle(Component $component)
        {
            return $this->factory($this);
        }
    }
}