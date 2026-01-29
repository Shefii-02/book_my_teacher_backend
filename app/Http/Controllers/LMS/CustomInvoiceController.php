<?php

namespace App\Http\Controllers\LMS;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreSubCategoryRequest;
use App\Models\CourseCategory;
use App\Models\CourseSubCategory;
use App\Models\CustomInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomInvoiceController extends Controller
{

  public function index()
  {
    $invoices = CustomInvoice::latest()->paginate(20);
    return view('company.custom_invoices.index', compact('invoices'));
  }

  public function create()
  {
    return view('company.custom_invoices.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'customer_name' => 'required',
      'items.*.title' => 'required',
      'items.*.price' => 'required|numeric',
      'items.*.quantity' => 'required|integer|min:1',
    ]);

    $subtotal = collect($request->items)->sum(fn($i) => $i['price'] * $i['quantity']);
    $taxAmount = ($subtotal * $request->tax_percent) / 100;
    $grandTotal = $subtotal - $request->discount + $taxAmount;

    $invoice = CustomInvoice::create([
      'invoice_no' => 'INV-' . now()->timestamp,
      'customer_name' => $request->customer_name,
      'customer_email' => $request->customer_email,
      'customer_mobile' => $request->customer_mobile,
      'customer_address' => $request->customer_address,
      'subtotal' => $subtotal,
      'discount' => $request->discount ?? 0,
      'tax_percent' => $request->tax_percent ?? 0,
      'tax_amount' => $taxAmount,
      'grand_total' => $grandTotal,
      'invoice_date' => now(),
      'status' => 'paid',
    ]);

    foreach ($request->items as $item) {
      $invoice->items()->create([
        'title' => $item['title'],
        'quantity' => $item['quantity'],
        'price' => $item['price'],
        'total' => $item['price'] * $item['quantity'],
      ]);
    }

    return redirect()->route('company.custom.invoices');
  }

  public function download(CustomInvoice $invoice)
  {
    $pdf = PDF::loadView('company.custom_invoices.pdf', compact('invoice'));
    return $pdf->download($invoice->invoice_no . '.pdf');
  }
}
