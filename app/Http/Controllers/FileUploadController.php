<?php

namespace App\Http\Controllers;

use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileUploadController extends Controller
{
    private FileUploadService $fileUploadService;

    /**
     * @param FileUploadService $fileUploadService
     */
    function __construct(FileUploadService $fileUploadService)
    {

        $this->fileUploadService = $fileUploadService;
    }

    public function upload(Request $request): RedirectResponse
    {
        Log::info("Received file upload request, validating file.");

        // Validate the file to ensure it's a CSV and less than 2MB
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048', // Limit size to 2MB and only allow CSV files
        ]);

        try {
            // set max execution time to 1 minute
            ini_set('max_execution_time', 60);

            $this->fileUploadService->processUploadedFile($request->file('file'));
        } catch (\Exception $e) {
            Log::error("Error processing file: " . $e->getMessage());
            return back()->with('error', 'Error processing file: ' . $e->getMessage());
        }

        return back()->with('success', 'File uploaded and processed successfully!');
    }
}
