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
namespace PowerEcommerce\Framework\Routing {
    use PowerEcommerce\System\Object;

    /**
     * @method $this setId(string)
     * @method string getId()
     *
     * @method $this setPort(string)
     * @method string getPort()
     *
     * @method $this setProcess(string)
     * @method string getProcess()
     *
     * @method $this setThread(string)
     * @method string getThread()
     *
     * @method $this setPriority(int)
     * @method int getPriority()
     *
     * @method $this setModifiers(string)
     * @method string getModifiers()
     *
     * @method $this setComponents(Object)
     * @method \PowerEcommerce\System\Object getComponents()
     */
    abstract class Component extends Object
    {
        /**
         * @param string $id
         */
        public function __construct($id)
        {
            $this->setComponents(new Object);
            $this->setId($id);
        }

        /**
         * @param \PowerEcommerce\Framework\Routing\Component $component
         *
         * @return $this
         */
        abstract public function attach(Component $component);

        /**
         * @param \PowerEcommerce\Framework\Routing\Component $component
         *
         * @return \PowerEcommerce\System\Object
         */
        abstract public function handle(Component $component);
    }
}