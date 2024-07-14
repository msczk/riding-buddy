<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Return the invoice as PDF file
     *
     * @param string $invoiceId
     * @return void
     */
    public function download(string $invoiceId)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        return $user->downloadInvoice($invoiceId);
    }
}
