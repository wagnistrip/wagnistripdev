<?php
namespace App\Http\Controllers;
 
class FileDownloadController extends Controller
{
    public function index() {
        $file = '../storage/app/uploads/sample.pdf';
        $name = basename($file);
        return response()->download($file, $name);
    }
}