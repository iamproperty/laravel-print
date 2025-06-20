<?php

namespace IAMProperty\Printer\Contracts;

interface Renderer
{
    /**
     * The mime type of the rendered document.
     */
    public function format(): string;

    /**
     * Render a document.
     *
     * @param  string  $document
     */
    public function render($document): string;
}
