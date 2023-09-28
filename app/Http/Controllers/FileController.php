<?php

namespace App\Http\Controllers;

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
        Storage::disk('do_spaces')->put($file->getClientOriginalName(), file_get_contents($file)); // Faz o upload do arquivo para o espaço
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
