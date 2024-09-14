<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;
use SimpleXMLElement;

class ProductsController extends Controller
{
    /**
     * @return Response
     */
    public function generateFeed(): Response
    {
        // Fetch products with categories from the database
        $products = Product::with('categories')->get();

        // Create the root element for the XML document
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><products></products>');

        // Add each product to the XML
        foreach ($products as $product) {
            $productXml = $xml->addChild('product');
            $productXml->addChild('title', htmlspecialchars($product->name));
            $productXml->addChild('price', $product->price);

            // Add categories for each product
            $categoriesXml = $productXml->addChild('categories');
            foreach ($product->categories as $category) {
                $categoriesXml->addChild('category', htmlspecialchars($category->name));
            }
        }

        // Return the XML with the correct headers
        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml');
    }

}
