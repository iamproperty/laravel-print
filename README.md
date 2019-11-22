# Printer

- [Introduction](#introduction)
    - [Installation](#installation)
- [Writing Printables](#writing-printables)
    - [Configuring The View](#configuring-the-view)
    - [View Data](#view-data)
- [Rendering Printables](#rendering-printables)
    - [Previewing Printables In The Browser](#previewing-printables-in-the-browser)

<a name="introduction"></a>
## Introduction

Printer provides a way to render PDFs using an API similar to [Laravel's Mailable](https://laravel.com/docs/mail).

<a name="installation"></a>
### Installation

```sh
$ composer require iamproperty/printer
```

<a name="writing-printables"></a>
## Writing Printables

All of a printable class' configuration is done in the `build` method. Within this method, you may call the methods `view`, and `with` to configure the view to be printed.

### Configuring The View

Within a printable class' `build` method, you may use the `view` method to specify which template should be used when rendering the document's contents. Since each document typically uses a [Blade template](https://laravel.com/docs/blade) to render its contents, you have the full power and convenience of the Blade templating engine when building your document's HTML:

    /**
     * Build the document.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('printed.orders.invoice');
    }

<a name="view-data"></a>
### View Data

#### Via Public Properties

Typically, you will want to pass some data to your view that you can utilize when rendering the document's HTML. There are two ways you may make data available to your view. First, any public property defined on your printable class will automatically be made available to the view. So, for example, you may pass data into your printable class' constructor and set that data to public properties defined on the class:

    <?php

    namespace App\Printed;

    use App\Order;
    use IAMProperty\Printer\Printable;

    class OrderShipped extends Printable
    {
        /**
         * The order instance.
         *
         * @var Order
         */
        public $order;

        /**
         * Create a new printable instance.
         *
         * @return void
         */
        public function __construct(Order $order)
        {
            $this->order = $order;
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {
            return $this->view('printed.orders.shipped');
        }
    }

Once the data has been set to a public property, it will automatically be available in your view, so you may access it like you would access any other data in your Blade templates:

    <div>
        Price: {{ $order->price }}
    </div>

#### Via The `with` Method:

If you would like to customize the format of your document's data before it is sent to the template, you may manually pass your data to the view via the `with` method. Typically, you will still pass data via the printable class' constructor; however, you should set this data to `protected` or `private` properties so the data is not automatically made available to the template. Then, when calling the `with` method, pass an array of data that you wish to make available to the template:

    <?php

    namespace App\Printed;

    use App\Order;
    use IAMProperty\Printer\Printable;

    class OrderShipped extends Printable
    {
        /**
         * The order instance.
         *
         * @var Order
         */
        protected $order;

        /**
         * Create a new printable instance.
         *
         * @return void
         */
        public function __construct(Order $order)
        {
            $this->order = $order;
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {
            return $this->view('printed.orders.shipped')
                        ->with([
                            'orderName' => $this->order->name,
                            'orderPrice' => $this->order->price,
                        ]);
        }
    }

Once the data has been passed to the `with` method, it will automatically be available in your view, so you may access it like you would access any other data in your Blade templates:

    <div>
        Price: {{ $orderPrice }}
    </div>

<a name="rendering-printables"></a>
## Rendering Printables

Sometimes you may wish to capture the HTML content of a printable without converting it to a PDF. To accomplish this, you may call the `toHtml` method of the printable. This method will return the evaluated contents of the printable as a string:

    $invoice = App\Invoice::find(1);

    return (new App\Printed\InvoicePaid($invoice))->toHtml();

<a name="previewing-printables-in-the-browser"></a>
### Previewing Printables In The Browser

When designing a printable's template, it is convenient to quickly preview the rendered printable in your browser like a typical Blade template. For this reason, you may return any printable directly from a route Closure or controller. When a printable is returned, it will be rendered and displayed in the browser, allowing you to quickly preview its design without needing to open a separate PDF file:

    Route::get('printable', function () {
        $invoice = App\Invoice::find(1);

        return new App\Printed\InvoicePaid($invoice);
    });

It's also possible to use the `Printer` facade to render a printable's template, without rendering the document:

    Route::get('printable', function () {
        $invoice = App\Invoice::find(1);

        return Printer::render(new App\Printed\InvoicePaid($invoice));
    });
