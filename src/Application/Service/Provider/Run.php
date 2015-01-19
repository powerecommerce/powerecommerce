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

namespace PowerEcommerce\Application\Service\Provider {
    use Pimple\Container;
    use PowerEcommerce\Application\Service\Provider;

    /**
     * Class Run
     * @package PowerEcommerce\Application\Service\Provider
     */
    class Run implements Provider
    {
        /**
         * Registers services on the given container.
         *
         * This method should only be used to configure services and parameters.
         * It should not get services.
         *
         * @param Container $app An Container instance
         */
        function register(Container $app)
        {
            $this->run($app);
        }

        /**
         * @param Container $app
         */
        private function run(Container $app)
        {
            !isset($app['run']) && $app['run'] = $app->factory(function ($app) {
                /** @var \PowerEcommerce\Application\Application $app */
                $app['route/collection'] = $app->router()->handle($app['router/target']);
            });
        }
    }
}