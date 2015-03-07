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
namespace PowerEcommerce\App\PowerEcommerce\Component\Core\Service {
    use PowerEcommerce\System\Service;

    class Boot extends Service
    {
        protected function _call()
        {
            $iterator = new \GlobIterator($this->app->get('boot_dir') . DIRECTORY_SEPARATOR . "*.php");

            $up = function (\PowerEcommerce\System\App\Boot $boot) {
                $boot->up($this->app);
            };
            /** @var \SplFileInfo $file */
            foreach ($iterator as $file) {
                /** @var \PowerEcommerce\Application\Component\Boot $boot */
                $boot = require $file->getPathname();
                $up($boot);
            }
        }

        protected function _gc() { }

        protected function _init()
        {
            !$this->app->has('base_dir') && $this->invalid('base_dir not defined.');

            if (!$this->app->has('boot_dir')) {
                $this->app->set('boot_dir', $this->app->get('base_dir') . DIRECTORY_SEPARATOR . 'boot');
            }
        }
    }
}