<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show list of products
     *
     *
     * @return Response
     */
    function __construct()
    {
        $path = storage_path('app/json_data.txt');
        $json_data = json_decode(file_get_contents($path), true);
        $this->products = $json_data["products"];
        $this->title = $json_data["title"];
        $this->conversion = $json_data["conversion"];
    }

    public function index($currency = "SAR")
    {
        $currencies = ["SAR", "INR", "AED"];
        $currency = strtoupper($currency);
        if (!in_array($currency, $currencies)) {
            $currency = "SAR";
        }
        $this->currency = $currency;
        $this->updateProductPrice();
        return view('home.index',
            ['products' => $this->products,
                'title' => $this->title,
                'currency' => $currency,
                'currencies' => $currencies
            ]);
    }

    private function updateProductPrice()
    {
        foreach ($this->products as &$product) {
            $this->convertPrice($product);
        }
    }

    private function convertPrice(&$product)
    {
        if ($product["currency"] !== $this->currency) {
            $new_price = $product["price"] * ($this->getRate($product["currency"], $this->currency));
            $product["price"] = number_format((float)$new_price, 2, '.', '');
        }
        $product["currency"] = $this->currency;
    }

    private function getRate($from, $to)
    {
        $conversion_data = array_first($this->conversion, function ($value, $key) use ($from, $to) {
            if (($from == $value['from'] && $to == $value['to'])
                || ($to == $value['from'] && $from == $value['to'])
            ) {
                return true;
            }
            return false;
        });
        if ($from == $conversion_data['from']) {
            return $conversion_data['rate'];
        }
        return (1 / $conversion_data['rate']);

    }
}