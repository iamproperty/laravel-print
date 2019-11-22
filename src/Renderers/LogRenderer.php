<?php

namespace IAMProperty\Printer\Renderers;

use IAMProperty\Printer\Contracts\Renderer as RendererContract;
use Psr\Log\LoggerInterface;

class LogRenderer extends Renderer implements RendererContract
{
    /**
     * The Logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Create a new log renderer instance.
     *
     * @param  \Psr\Log\LoggerInterface  $logger
     * @return void
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function render($document): string
    {
        $this->logger->debug($document);

        return $document;
    }

    /**
     * Get the logger for the LogRenderer instance.
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function logger()
    {
        return $this->logger;
    }
}
