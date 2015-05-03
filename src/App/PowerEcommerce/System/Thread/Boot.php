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
namespace PowerEcommerce\App\PowerEcommerce\System\Thread {
    use PowerEcommerce\System\Boot\Context;
    use PowerEcommerce\System\Flow\Priority;
    use PowerEcommerce\System\Object;
    use PowerEcommerce\System\Port\Scheduler\ItemWrapper as PortWrapper;
    use PowerEcommerce\System\Scheduler;
    use PowerEcommerce\System\Scheduler\ItemWrapper;
    use PowerEcommerce\System\Thread;

    class Boot extends Thread
    {

        /** @type \PowerEcommerce\System\Boot\Context */
        protected $_context;

        /** @type \PowerEcommerce\System\Object */
        protected $_data;

        /**
         * @param string $xml
         */
        protected function _convert($xml)
        {
            $parser = xml_parser_create();
            xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
            xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
            xml_parse_into_struct($parser, $xml, $tags);
            xml_parser_free($parser);

            $path     = [];
            $rollback = [];

            foreach ($tags as $tag) {
                switch ($tag['type']) {
                    case 'open':
                        $i = 1;

                        $path[] = $tag['tag'];
                        isset($tag['attributes']['name']) && ($path[] = $tag['attributes']['name']) && $i++;
                        $rollback[] = $i;

                        $this->_convertTagOpen($tag, $path);
                        break;

                    case 'complete':
                        $i = 1;

                        $path[] = $tag['tag'];
                        isset($tag['attributes']['name']) && ($path[] = $tag['attributes']['name']) && $i++;
                        $rollback[] = $i;
                        $this->_convertTagComplete($tag, $path);

                    case 'close':
                        $end = sizeof($rollback) - 1;
                        $max = $rollback[$end];

                        for ($j = 0; $j < $max; ++$j) {
                            unset($path[sizeof($path) - 1]);
                        }
                        unset($rollback[$end]);
                        //reset keys
                        $rollback = array_values($rollback);
                        break;

                    default:
                        break;
                }
            }
        }

        /**
         * @param array $tag
         * @param array $path
         */
        protected function _convertTagComplete(array $tag, array $path)
        {
            $this->_convertTagOpen($tag, $path);
        }

        /**
         * @param array $tag
         * @param array $path
         */
        protected function _convertTagOpen(array $tag, array $path)
        {
            $context = $this->_context;
            $index   = 0;
            $end     = sizeof($path);

            foreach ($path as $key) {
                ++$index;

                if (!isset($context[$key])) {
                    $context[$key] = new Context();
                }
                $context = $context[$key];

                if ($index < $end) {
                    continue;
                }

                if (isset($tag['attributes'])) {
                    foreach ($tag['attributes'] as $name => $attribute) {
                        'name' != $name && $context[$name] = $attribute;
                    }
                }
            }
        }

        /**
         * @return $this
         */
        public function abort()
        {
            return $this;
        }

        /**
         * @return $this
         */
        public function end()
        {
            return $this;
        }

        /**
         * @return $this
         */
        public function execute()
        {
            /** @type \SimpleXMLElement $boot */
            foreach ($this->_data->getData() as $xml) {
                $this->_convert($xml);
            }
            $ports     = $this->_context->get('boot')->get('port');
            $scheduler = new Scheduler();

            foreach ($ports as $portId => $port) {
                if (is_object($port)) {
                    /** @type \PowerEcommerce\System\Boot\Context $port */
                    $scheduler->set($portId, new PortWrapper(Priority::NORMAL));
                    $processes  = $port->get('process');
                    $portObject = $scheduler->get($portId);

                    foreach ($processes as $processId => $process) {
                        if (is_object($process)) {
                            /** @type \PowerEcommerce\System\Boot\Context $process */
                            $portObject->set($processId, new ItemWrapper($process->get('src'), Priority::NORMAL));
                            $threads       = $process->get('thread');
                            $processObject = $portObject->get($processId);

                            foreach ($threads as $threadId => $thread) {
                                if (is_object($thread)) {
                                    /** @type \PowerEcommerce\System\Boot\Context $thread */
                                    $pattern =
                                        '/' . addcslashes($thread->get('match'), '/') . '/' . $thread->get('modifiers');

                                    if (empty($thread->get('match')) || preg_match($pattern, $_SERVER['REQUEST_URI'])) {
                                        $processObject->set($threadId,
                                                            new ItemWrapper($thread->get('src'),
                                                                            $thread->get('priority')));
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $scheduler->run();
            return $this;
        }

        /**
         * @return $this
         */
        public function load()
        {
            $this->_data    = new Object();
            $this->_context = new Context();

            $sm = $this->app()->sharedMemory();

            $glob = new \GlobIterator($sm['BootLoaderDir'] . $sm['DS'] . "*.xml");

            /** @type \SplFileInfo $file */
            foreach ($glob as $file) {
                $pathname = $file->getPathname();
                $this->_data->push(file_get_contents($pathname));
            }
            return $this;
        }
    }
}