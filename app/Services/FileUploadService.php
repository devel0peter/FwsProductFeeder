<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use SplFileObject;

class FileUploadService
{

    const validColumnNames = ['Megnevezés', 'Ár', 'Kategória 1', 'Kategória 2', 'Kategória 3'];

    public function processUploadedFile(array|UploadedFile|null $file): void
    {
        $file = new SplFileObject($file->getRealPath(), 'r');

        if (!$this->isValidFileHeader($file)) {
            throw new InvalidArgumentException("Invalid file header. Please make sure the file has the following columns: " . implode(', ', self::validColumnNames));
        }

        // iterate over the file and create a Product for each row
        // this might take a while, should be done in a queue job
        $this->importProductsFromFile($file);
    }

    private function updateProgress(int $updatedProductsCount, int $totalRows): void
    {
        Log::info("Importing products: $updatedProductsCount/$totalRows");
    }

    /**
     * @param SplFileObject $file
     * @return void
     */
    private function importProductsFromFile(SplFileObject $file): void
    {
        $totalRows = $this->getTotalRows($file);
        $updatedProductsCount = 0;
        Log::info("Processing file with $totalRows products...");

        // make sure we are at the second line of the file, as first line is the header
        $file->seek(1);

        while (!$file->eof()) {
            $row = $file->fgetcsv();

            if (empty($row) || $row[0] == "") {
                continue;
            }

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
            $updatedProductsCount++;
            $this->updateProgress($updatedProductsCount, $totalRows);
        }
    }

    /**
     * @param SplFileObject $file
     * @return bool
     */
    private function isValidFileHeader(SplFileObject $file): bool
    {
        // make sure we are on the first line
        $file->rewind();
        $header = $file->fgetcsv();

        $file->rewind(); // rewind the file to the beginning
        return $header === self::validColumnNames;
    }

    /**
     * @param SplFileObject $file
     * @return int
     */
    private function getTotalRows(SplFileObject $file): int
    {
        $file->rewind(); // Make sure we are at the beginning of the file

        $file->seek(PHP_INT_MAX); // Seek to the last line in the file
        $totalRows = $file->key() - 1; // Get the current line number, -1 because the first row is the header

        // rewind
        $file->rewind();
        return $totalRows;
    }
}
