<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function generateXmlFeed()
    {
        $products = Product::with('categories')->get();

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><products/>');

        foreach ($products as $product) {
            $productNode = $xml->addChild('product');
            $productNode->addChild('title', htmlspecialchars($product->name));
            $productNode->addChild('price', $product->price);

            $categoriesNode = $productNode->addChild('categories');
            foreach ($product->categories as $category) {
                $categoriesNode->addChild('category', htmlspecialchars($category->name));
            }
        }

        return response($xml->asXML(), 200)->header('Content-Type', 'text/xml');
    }
}
