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

namespace PowerEcommerce\System\Security\Component {
    use PowerEcommerce\System\Data\Boolean;
    use PowerEcommerce\System\Data\Collection;
    use PowerEcommerce\System\Data\String;
    use PowerEcommerce\System\Security\Component;

    /**
     * Class Role
     * @package PowerEcommerce\System\Security\Component
     */
    class Role extends Component
    {
        /**
         * @var \PowerEcommerce\System\Data\Collection
         */
        private $children;

        /**
         * @param \PowerEcommerce\System\Data\String $name
         */
        function __construct(String $name)
        {
            $this->children = new Collection();
            parent::__construct($name);
        }

        /**
         * @param \PowerEcommerce\System\Security\Component $component
         * @return $this
         */
        function attach(Component $component)
        {
            !($component instanceof \PowerEcommerce\System\Security\Component\Privilege) && $this->invalid();
            $this->children->add($component->getValue(), $component);
            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Security\Component $component
         * @return $this
         */
        function detach(Component $component)
        {
            !($component instanceof \PowerEcommerce\System\Security\Component\Privilege) && $this->invalid();
            $this->children->del($component->getValue());
            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Security\Component $component
         * @return \PowerEcommerce\System\Data\Boolean
         */
        function isGranted(Component ...$component)
        {
            $granted = true;

            /** @var Component $item */
            foreach ($component as $item) {
                if ($item instanceof \PowerEcommerce\System\Security\Component\Privilege
                    && $this->children->exists($item->getValue())->isFalse()
                ) {
                    return new Boolean(false);
                }
                if ($item instanceof \PowerEcommerce\System\Security\Component\Privilege) {
                    $granted = $granted && $item->isGranted(...$component)->getValue();
                }
            }
            return new Boolean($granted);
        }
    }
}