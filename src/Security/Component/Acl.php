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
    use PowerEcommerce\System\Data\Argument;
    use PowerEcommerce\System\Data\Collection;
    use PowerEcommerce\System\Security\Component;
    use PowerEcommerce\System\TypeCode;

    /**
     * Class Acl
     *
     * <code><?php
     *
     * $p1 = new \PowerEcommerce\System\Security\Component\Privilege('p1');
     * $p2 = new \PowerEcommerce\System\Security\Component\Privilege('p2');
     *
     * $r1 = new \PowerEcommerce\System\Security\Component\Role('r1');
     * $r2 = new \PowerEcommerce\System\Security\Component\Role('r2');
     * $r1->attach($p1);
     *
     * $rs1 = new \PowerEcommerce\System\Security\Component\Resource('rs1');
     * $rs2 = new \PowerEcommerce\System\Security\Component\Resource('rs2');
     * $rs1->attach($r1);
     *
     * $a1 = new \PowerEcommerce\System\Security\Component\Acl('a1');
     * $a1->attach($rs1);
     *
     * var_dump($a1->isGranted( //true
     *      $p1, $rs1, $r1
     * ));
     *
     * var_dump($a1->isGranted( //false
     *      $p1, $rs2, $r1
     * ));
     *
     * var_dump($a1->isGranted( //false
     *      $p1, $rs1, $r2
     * ));
     *
     * var_dump($a1->isGranted( //false
     *      $p2, $rs1, $r1
     * ));
     *
     * ?></code>
     *
     * @package PowerEcommerce\System\Security\Component
     */
    class Acl extends Component
    {
        /**
         * @var \PowerEcommerce\System\Data\Collection
         */
        private $children;

        /**
         * @param string|\PowerEcommerce\System\Data\String $name
         */
        function __construct($name)
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
            (new Argument($component))->strict(TypeCode::RESOURCE);
            $this->children->add((string)$component, $component, 'This component already exists');

            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Security\Component $component
         * @return $this
         */
        function detach(Component $component)
        {
            (new Argument($component))->strict(TypeCode::RESOURCE);
            $this->children->del((string)$component);

            return $this;
        }

        /**
         * @param Component $component
         * @return bool
         */
        function isGranted(Component ...$component)
        {
            $granted = true;

            /** @var Component $item */
            foreach ($component as $item) {
                if ($item->getTypeCode() === TypeCode::RESOURCE
                    && !$this->children->get((string)$item)
                ) return false;

                if ($item->getTypeCode() === TypeCode::RESOURCE)
                    $granted = $granted && $item->isGranted(...$component);
            }

            return $granted;
        }

        /**
         * @return int TypeCode
         */
        function getTypeCode()
        {
            return TypeCode::ACL;
        }
    }
}
