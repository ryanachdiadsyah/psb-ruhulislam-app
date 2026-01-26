<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function showInvocePage(Request $request)
    {
        $user = $request->user();

        $invoices = Invoice::query()
            ->where('user_id', $user->id)
            ->with(['items'])
            ->orderBy('due_date')
            ->get();
        return view('app.invoice-list',[
            'invoices' => $invoices,
        ]);
    }

    public function showInvoiceDetail(Invoice $invoice)
    {
        abort_if($invoice->user_id !== auth()->id(), 403);
        $invoice->load('items');
        return view('app.invoice-detail', [
            'invoice' => $invoice,
        ]);
    }
}
