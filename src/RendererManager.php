<?php

namespace IAMProperty\Printer;

use IAMProperty\Printer\Renderers\ArrayRenderer;
use IAMProperty\Printer\Renderers\LogRenderer;
use Illuminate\Log\LogManager;
use Illuminate\Support\Manager;
use Psr\Log\LoggerInterface;

class RendererManager extends Manager
{
    /**
     * Create an instance of the Log Renderer driver.
     *
     * @return \IAMProperty\Printer\Renderers\LogRenderer
     */
    protected function createLogDriver()
    {
        $logger = $this->container->make(LoggerInterface::class);

        if ($logger instanceof LogManager) {
            $logger = $logger->channel($this->config->get('printer.log_channel'));
        }

        return new LogRenderer($logger);
    }

    /**
     * Create an instance of the Array Renderer driver.
     *
     * @return \IAMProperty\Printer\Renderers\ArrayRenderer
     */
    protected function createArrayDriver()
    {
        return new ArrayRenderer();
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config->get('printer.default');
    }
}
