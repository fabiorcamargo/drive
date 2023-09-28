<?php

namespace App\Http\Controllers;

use App\Jobs\UploadFileToDigitalOcean;
use App\Jobs\UploadProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = Storage::disk('do_spaces')->files('/'); // Obtém a lista de arquivos no espaço

        //dd($files);
        return view('files.index', compact('files'));
    }

    public function upload(Request $request)
    {
        
        $file = $request->file('file');
        
        // Armazene temporariamente o arquivo em disco
        Storage::disk('temp_uploads')->put($file->getClientOriginalName(), file_get_contents($file)); // Faz o upload do arquivo para o espaço
        $tempFilePath = Storage::disk('temp_uploads')->path($file->getClientOriginalName());

        $name = $file->getClientOriginalName();

        UploadProcess::dispatch($name, $tempFilePath);

        
        return redirect()->route('files.index')->with('success', 'Arquivo enviado com sucesso!');
    }

    public function download($filename)
    {
        $file = Storage::disk('do_spaces')->path($filename);
        return Storage::download($filename);
    }

    public function delete($filename)
    {
        Storage::disk('do_spaces')->delete($filename); // Exclui o arquivo do espaço
        return redirect()->route('files.index')->with('success', 'Arquivo excluído com sucesso!');
    }
}
