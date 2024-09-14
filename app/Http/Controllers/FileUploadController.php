<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request): RedirectResponse
    {
        // Validate the file to ensure it's a CSV and less than 2MB
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048', // Limit size to 2MB and only allow CSV files
        ]);

            // Store the file in the "uploads" directory inside the public storage
            $filePath = $request->file('file')->store('uploads', 'public');

            // Return a success message along with the file path
            return back()->with('success', 'CSV file uploaded successfully!')
                ->with('file', $filePath);
    }
}
