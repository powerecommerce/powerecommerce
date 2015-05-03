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
    use PowerEcommerce\System\App;

    class Thread extends Component
    {
        /**
         * @param string $source
         * @param string $process
         * @param string $port
         */
        public function __construct($source,
                                    $process = '\PowerEcommerce\App\PowerEcommerce\System\Process\Router',
                                    $port = 'powerecommerce.system.router')
        {
            parent::__construct($source);

            $this->setThread($source);
            $this->setProcess($process);
            $this->setPort($port);
        }

        /**
         * @param \PowerEcommerce\Framework\Routing\Component $component
         *
         * @return $this
         */
        public function attach(Component $component)
        {
            $this->invalid();
        }

        /**
         * @param \PowerEcommerce\Framework\Routing\Component $component
         *
         * @return \PowerEcommerce\System\Object
         */
        public function handle(Component $component)
        {
            $port    = App::singleton()->scheduler()->get($this->getPort());
            $process = $port->process($this->getProcess());

            if ($priority = $this->getPriority()) {
                $process->createThread($this->getThread(), $priority);
            }
            else {
                $process->createThread($this->getThread());
            }
            return $this;
        }
    }
}