<?php

namespace IAMProperty\Printer;

use IAMProperty\Printer\Contracts\Printable as PrintableContract;
use IAMProperty\Printer\Contracts\Printer;
use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Traits\Localizable;
use ReflectionClass;
use ReflectionProperty;
use Symfony\Component\HttpFoundation\Response;

class Printable implements Htmlable, PrintableContract, Renderable, Responsable
{
    use Localizable;

    /**
     * The locale of the message.
     *
     * @var string
     */
    public $locale;


    /**
     * The view to use for the message.
     *
     * @var string
     */
    public $view;

    /**
     * The view data for the message.
     *
     * @var array
     */
    public $viewData = [];

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->withLocale($this->locale, function () {
            Container::getInstance()->call([$this, 'build']);

            return Container::getInstance()->make('printer')->render(
                $this->view, $this->buildViewData()
            );
        });
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $printer = Container::getInstance()->make('printer');

        return $this->print($printer);
    }

    /**
     * Print the page using using the given printer.
     *
     * @param  \IAMProperty\Printer\Contracts\Printer  $printer
     * @return string
     */
    public function print(Printer $printer): string
    {
        return $this->withLocale($this->locale, function () use ($printer) {
            Container::getInstance()->call([$this, 'build']);

            return $printer->raw($this->view, $this->buildViewData());
        });

    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return new Response($this->render(), Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Build the view data for the message.
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function buildViewData()
    {
        $data = $this->viewData;

        foreach ((new ReflectionClass($this))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->getDeclaringClass()->getName() !== self::class) {
                $data[$property->getName()] = $property->getValue($this);
            }
        }

        return $data;
    }

    /**
     * Set the view and view data for the message.
     *
     * @param  string  $view
     * @param  array  $data
     * @return $this
     */
    public function view($view, array $data = [])
    {
        $this->view = $view;
        $this->viewData = array_merge($this->viewData, $data);

        return $this;
    }

    /**
     * Set the view data for the message.
     *
     * @param  string|array  $key
     * @param  mixed   $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->viewData = array_merge($this->viewData, $key);
        } else {
            $this->viewData[$key] = $value;
        }

        return $this;
    }
}
