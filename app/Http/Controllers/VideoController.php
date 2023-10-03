<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function streamVideo(Request $request)
    {
        //dd($request->all());
        $filePath = $request->video; // Caminho para o vídeo no Space
        $fileSize = Storage::disk('public')->size($filePath);

        //dd($fileSize);

        $headers = [
            'Content-Type' => 'video/mp4', // Defina o tipo de conteúdo correto
            'Content-Length' => $fileSize,
            'Accept-Ranges' => 'bytes',
        ];

        // Verifique se o cliente suporta intervalos de bytes (para streaming)
        if (request()->hasHeader('range')) {
            return response()->stream(function () use ($filePath) {
                $handle = Storage::disk('public')->readStream($filePath);
                fpassthru($handle);
                fclose($handle);
            }, 200, $headers);
        } else {
            // Se o cliente não suporta intervalos de bytes, transmita o arquivo inteiro
            return Storage::disk('do_spaces')->response($filePath, null, $headers);
        }
    }
}
