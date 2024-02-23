<?php

namespace App\Observers;

use App\Models\Files;
use Illuminate\Support\Facades\Storage;

class FilesObserver
{
    /**
     * Handle the Files "created" event.
     */
    public function created(Files $files): void
    {
        // Limpar a pasta storage/app/chunks
        Storage::deleteDirectory('chunks');

        // Recriar a pasta vazia
        Storage::makeDirectory('chunks');
    }

    /**
     * Handle the Files "updated" event.
     */
    public function updated(Files $files): void
    {
        //
    }

    /**
     * Handle the Files "deleted" event.
     */
    public function deleted(Files $files): void
    {
        //
    }

    /**
     * Handle the Files "restored" event.
     */
    public function restored(Files $files): void
    {
        //
    }

    /**
     * Handle the Files "force deleted" event.
     */
    public function forceDeleted(Files $files): void
    {
        //
    }
}
