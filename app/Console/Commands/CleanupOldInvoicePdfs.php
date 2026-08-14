<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Quotation;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Signature('app:cleanup-old-invoice-pdfs')]
#[Description('Delete generated invoice and quotation PDF files older than one week')]
class CleanupOldInvoicePdfs extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $deleted = $this->cleanupDirectory('invoices', Invoice::class)
            + $this->cleanupDirectory('quotations', Quotation::class);

        $this->info("Deleted {$deleted} PDF(s) older than one week.");
    }

    /**
     * @param  class-string<Model>  $model
     */
    private function cleanupDirectory(string $directory, string $model): int
    {
        $disk = Storage::disk('public');
        $cutoff = now()->subWeek()->timestamp;
        $deleted = 0;

        foreach ($disk->files($directory) as $path) {
            if ($disk->lastModified($path) > $cutoff) {
                continue;
            }

            $disk->delete($path);
            $model::where('pdf_path', $path)->update(['pdf_path' => null]);
            $deleted++;
        }

        return $deleted;
    }
}
