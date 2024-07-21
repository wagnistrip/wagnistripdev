<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Throwable;

class LogXml
{
    function logXml(string $data, string $path, string $logLevel = 'info'): void
    {
        $xmlString = $data instanceof \SimpleXMLElement ? $data->asXML() : $data; // Handle different input types

        try {
            $file = fopen(Storage::path($path), 'a'); // Open in append mode using Storage facade
            fwrite($file, $xmlString . "\n"); // Write XML with a newline for separation
            fclose($file);
        } catch (Throwable $e) {
            // Log error (implement your logging mechanism here)
            report($e); // Example using Laravel's report helper
        }
    }
}

