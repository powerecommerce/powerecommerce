<?php

/**
 * Copyright (c) 2015 DD Art Tomasz Duda
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
    use PowerEcommerce\System\Data\Collection;
    use PowerEcommerce\System\Data\String;
    use PowerEcommerce\System\Routing\Component;

    /**
     * Class Service
     * @package PowerEcommerce\System\Routing\Component
     */
    class Service extends Component
    {
        /**
         * @var \PowerEcommerce\System\Data\Collection
         */
        private $args;

        /**
         * @param \PowerEcommerce\System\Data\String $name
         * @param \PowerEcommerce\System\Data\Collection $args
         */
        function __construct(String $name, Collection $args = null)
        {
            null === $args && $args = new Collection();
            $this->args = $args;
            parent::__construct($name);
        }

        /**
         * @param \PowerEcommerce\System\Routing\Component $component
         * @return $this
         */
        function attach(Component $component)
        {
            $this->invalid();
        }

        /**
         * @param \PowerEcommerce\System\Routing\Component $component
         * @return $this
         */
        function detach(Component $component)
        {
            $this->invalid();
        }

        /**
         * @param \PowerEcommerce\System\Routing\Component $component
         * @return \PowerEcommerce\System\Routing\Component
         */
        function handle(Component $component)
        {
            !($component instanceof \PowerEcommerce\System\Routing\Component\Target) && $this->invalid();

            $service = $this->toString();
            new $service(...$this->args->getValue());
            return $this;
        }
    }
}