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
namespace PowerEcommerce\App\PowerEcommerce\Component\Core {
    use PowerEcommerce\App\App;

    /**
     * @method \PowerEcommerce\App\PowerEcommerce\Component\Core\Service\Router Router()
     * @method \PowerEcommerce\App\PowerEcommerce\Component\Core\Service\Boot Boot()
     * @method \PowerEcommerce\App\PowerEcommerce\Component\Core\Service\Main Main()
     * @method \PowerEcommerce\App\PowerEcommerce\Component\Core\Service\Request Request()
     * @method \PowerEcommerce\App\PowerEcommerce\Component\Core\Service\Response Response()
     * @method \PowerEcommerce\App\PowerEcommerce\Component\Core\Service\FileSystem FileSystem()
     * @method \PowerEcommerce\App\PowerEcommerce\Component\Core\Service\Broker Broker()
     */
    class Facade extends \PowerEcommerce\System\App\Facade
    {
        /**
         * @param \PowerEcommerce\App\App $app
         */
        public function __construct(App $app)
        {
            parent::__construct($app);

            $this->Router     = $this->_register('\PowerEcommerce\App\PowerEcommerce\Component\Core\Service\Router');
            $this->Main       = $this->_register('\PowerEcommerce\App\PowerEcommerce\Component\Core\Service\Main');
            $this->Boot       = $this->_register('\PowerEcommerce\App\PowerEcommerce\Component\Core\Service\Boot');
            $this->Request    = $this->_register('\PowerEcommerce\App\PowerEcommerce\Component\Core\Service\Request');
            $this->Response   = $this->_register('\PowerEcommerce\App\PowerEcommerce\Component\Core\Service\Response');
            $this->FileSystem =
                $this->_register('\PowerEcommerce\App\PowerEcommerce\Component\Core\Service\FileSystem');
            $this->Broker     = $this->_register('\PowerEcommerce\App\PowerEcommerce\Component\Core\Service\Broker');
        }
    }
}