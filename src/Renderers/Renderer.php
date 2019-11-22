<?php

namespace IAMProperty\Printer\Renderers;

use IAMProperty\Printer\Contracts\Renderer as RendererContract;

abstract class Renderer implements RendererContract
{
    /**
     * {@inheritdoc}
     */
    public function format(): string
    {
        return 'text/html';
    }
}
