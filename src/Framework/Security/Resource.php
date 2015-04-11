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
namespace PowerEcommerce\Framework\Security {

    class Resource extends Component
    {
        /**
         * @param \PowerEcommerce\Framework\Security\Component $component
         *
         * @return $this
         */
        public function attach(Component $component)
        {
            !($component instanceof \PowerEcommerce\Framework\Security\Role) && $this->invalid();
            return $this->add($component->getId(), $component);
        }

        /**
         * @param \PowerEcommerce\Framework\Security\Component $component
         *
         * @return $this
         */
        public function detach(Component $component)
        {
            !($component instanceof \PowerEcommerce\Framework\Security\Role) && $this->invalid();
            return $this->del($component->getId());
        }

        /**
         * @param \PowerEcommerce\Framework\Security\Component $component
         *
         * @return bool
         */
        public function isGranted(Component ...$component)
        {
            $granted = true;

            /** @var Component $item */
            foreach ($component as $item) {
                if ($item instanceof \PowerEcommerce\Framework\Security\Role && !$this->has($item->getId())
                ) {
                    return false;
                }
                if ($item instanceof \PowerEcommerce\Framework\Security\Role) {
                    $granted = $granted && $item->isGranted(...$component);
                }
            }
            return $granted;
        }
    }
}