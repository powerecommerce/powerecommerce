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
namespace PowerEcommerce\System\Boot {
    use PowerEcommerce\System\App;

    class Loader
    {

        /** @type \PowerEcommerce\System\App */
        private $_app;

        /** @type \PowerEcommerce\System\Boot[] */
        private $_boot = [];

        /** @type \GlobIterator */
        private $_glob;

        /**
         * @param \PowerEcommerce\System\App $app
         */
        final public function __construct(App $app)
        {
            $this->_app  = $app;
            $this->_glob =
                new \GlobIterator($this->_app->context()['BootLoaderDir'] . $this->_app->context()['DS'] . "*.php");
        }

        final public function down()
        {
            foreach ($this->_boot as $boot) {
                $boot->down();
            }
        }

        final public function up()
        {
            $init = function (\PowerEcommerce\System\Boot $boot) {
                $boot->init();
            };

            /** @type \SplFileInfo $file */
            foreach ($this->_glob as $file) {

                /** @type \PowerEcommerce\System\Boot $boot */
                $boot = require $file->getPathname();
                $boot = $boot::singleton($this->_app);
                $init($boot);

                $this->_boot[] = $boot;
            }

            foreach ($this->_boot as $boot) {
                $boot->up();
            }
        }
    }
}