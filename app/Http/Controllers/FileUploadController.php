<?php

namespace App\Http\Controllers;

use App\Jobs\UploadProcess;
use App\Models\Files;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class FileUploadController extends Controller {

    /**
     * @return Application|Factory|View
     */
   

    public function uploadLargeFiles(Request $request) {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

            $disk = Storage::disk(config('filesystems.default'));
            Storage::disk('temp_uploads')->put($fileName, file_get_contents($file)); // Faz o upload do arquivo para o espaço
            $tempFilePath = Storage::disk('temp_uploads')->path($fileName);

            
            $name = $fileName;

            $fileid = Files::create(['name' => $name, 'status' => 'Pendente']);

            //dd($name);
            UploadProcess::dispatch($name, $tempFilePath, $fileid);

            unlink($file->getPathname());

            
            $request->session()->flash('flash.banner', 'Arquivo enviado para fila de carregamento, atualize a página para acompanhar o status!');
            $request->session()->flash('flash.bannerStyle', 'success');

        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }
}
