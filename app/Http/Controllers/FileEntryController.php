<?php namespace App\Http\Controllers;

use App\Fileentry;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileEntryController extends Controller {

    public function index()
    {
        $entries = Fileentry::all();

        return view('fileentries.index', compact('entries'));
    }

    public function add(Request $request)
    {
        // Get the file uploaded - filefield is the name of the input to upload file
        $file = $request->file('filefield');

        // Get the file extension
        $extension = $file->getClientOriginalExtension();

        // Save the file to the local disk
        Storage::disk('pictures')->put($file->getFilename() . '.' . $extension, File::get($file));

        // Build the model
//        $entry = new Fileentry();
//        $entry->mime = $file->getClientMimeType();
//        $entry->original_filename = $file->getClientOriginalName();
//        $entry->filename = $file->getFilename() . '.' . $extension;
//        // Save the entry
//        $entry->save();

        Fileentry::create([
            'mime' => $file->getClientMimeType(),
            'original_filename' => $file->getClientOriginalName(),
            'filename' => $file->getFilename() . '.' . $extension
        ]);

        return redirect('fileentry');
    }

    public function get($filename)
    {
        $entry = Fileentry::where('filename', '=', $filename)->firstOrFail();
        $file = Storage::disk('pictures')->get($entry->filename);

        // This works even if you don't explicitly set the header for the file.
        return (new Response($file, 200))
            ->header('Content-type', $entry->mime);
    }

}
