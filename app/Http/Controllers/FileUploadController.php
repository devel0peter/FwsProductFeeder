<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class FileUploadController extends Controller
{
    const validColumnNames = ['Megnevezés', 'Ár', 'Kategória 1', 'Kategória 2', 'Kategória 3'];

    public function upload(Request $request): RedirectResponse
    {
        // Validate the file to ensure it's a CSV and less than 2MB
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048', // Limit size to 2MB and only allow CSV files
        ]);

        // Get the file from the request
        $file = $request->file('file');
        $handle = fopen($file, 'r');

        if (!$this->isValidFileHeader($handle)) {
            return back()->with('error', 'Invalid file header!');
        }

        // iterate over the file and create a Product for each row
        // this might take a while, should be done in a queue job
        while (($row = fgetcsv($handle, null, ',')) !== false)
        {
            /** @var Product $product */
            $product = Product::updateOrCreate([
                'name' => $row[0],
                'price' => $row[1]
            ]);

            if (isset($row[2])) {
                /** @var Category $category */
                $category = Category::firstOrCreate(['name' => $row[2]]);
                $product->categories()->attach($category->id);
            }

            if (isset($row[3])) {
                /** @var Category $category */
                $category = Category::firstOrCreate(['name' => $row[3]]);
                $product->categories()->attach($category->id);
            }

            if (isset($row[4])) {
                /** @var Category $category */
                $category = Category::firstOrCreate(['name' => $row[4]]);
                $product->categories()->attach($category->id);
            }

            $product->save();
        }

        // Store the file in the "uploads" directory inside the public storage
        $filePath = $request->file('file')->store('uploads', 'public');

        // Return a success message along with the file path
        return back()->with('success', 'CSV file uploaded successfully!')
            ->with('file', $filePath);
    }

    /**
     * @param $handle
     * @return bool
     */
    private function isValidFileHeader($handle): bool
    {

        // Read the first line of the file
        $header = fgetcsv($handle, null, ',');

        return $header === self::validColumnNames;
    }
}
