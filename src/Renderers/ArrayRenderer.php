<?php

namespace IAMProperty\Printer\Renderers;

use IAMProperty\Printer\Contracts\Renderer as RendererContract;
use Illuminate\Support\Collection;

class ArrayRenderer extends Renderer implements RendererContract
{
    /**
     * The collection of documents.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $documents;

    /**
     * Create a new array renderer instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->documents = new Collection();
    }

    /**
     * {@inheritdoc}
     */
    public function render($document): string
    {
        $this->documents[] = $document;

        return $document;
    }

    /**
     * Retrieve the collection of documents.
     *
     * @return \Illuminate\Support\Collection
     */
    public function documents()
    {
        return $this->documents;
    }

    /**
     * Clear all of the documents from the local collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function flush()
    {
        return $this->documents = new Collection();
    }
}
