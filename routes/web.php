<?php

use App\Http\Controllers\InvoicePdfController;
use App\Http\Controllers\QuotationPdfController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::middleware(['auth'])->group(function () {
    Route::get('admin/invoices/{invoice}/pdf', [InvoicePdfController::class, 'download'])
        ->name('invoices.pdf');

    Route::get('admin/quotations/{quotation}/pdf', [QuotationPdfController::class, 'download'])
        ->name('quotations.pdf');
});
