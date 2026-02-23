<?php

namespace App\Http\Controllers\LMS;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreSubCategoryRequest;
use App\Models\CourseCategory;
use App\Models\CourseSubCategory;
use App\Models\CustomInvoice;
use App\Models\CustomInvoiceItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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
      'customer_name' => 'required|string|max:255',
      'customer_email' => 'nullable|email',
      'customer_mobile' => 'nullable|string|max:20',
      'customer_address' => 'nullable|string',

      'items' => 'required|array|min:1',
      'items.*.title' => 'required|string',
      'items.*.quantity' => 'required|numeric|min:1',
      'items.*.price' => 'required|numeric|min:0',

      'discount' => 'nullable|numeric|min:0',
      'tax_percent' => 'nullable|numeric|min:0',
    ]);



    DB::beginTransaction();

    try {
      /* ---------- CALCULATIONS ---------- */
      $subtotal = collect($request->items)->sum(function ($i) {
        return $i['quantity'] * $i['price'];
      });

      $discount = $request->discount ?? 0;
      $taxPercent = $request->tax_percent ?? 0;
      $taxAmount = ($subtotal * $taxPercent) / 100;
      $grandTotal = ($subtotal - $discount) + $taxAmount;

      /* ---------- INVOICE ---------- */
      $invoice = CustomInvoice::create([
        'company_id' => auth()->user()->company_id,
        'user_id' => auth()->id(),
        'student_id' => $request->student_id,
        'invoice_no' => '#' . date('ymdhisu'),
        'customer_name' => $request->customer_name,
        'customer_email' => $request->customer_email,
        'customer_mobile' => $request->customer_mobile,
        'customer_address' => $request->customer_address,
        'invoice_date' => date('Y-m-d'),
        'subtotal' => $subtotal,
        'discount' => $discount,
        'tax_percent' => $taxPercent,
        'tax_amount' => $taxAmount,
        'grand_total' => $grandTotal,
        'status' => 'unpaid', // default
      ]);

      /* ---------- ITEMS ---------- */
      foreach ($request->items as $item) {
        CustomInvoiceItem::create([
          'custom_invoice_id' => $invoice->id,
          'title' => $item['title'],
          'quantity' => $item['quantity'],
          'price' => $item['price'],
          'total' => $item['quantity'] * $item['price'],
        ]);
      }

      DB::commit();

      return redirect()
        ->route('company.custom.invoices.index', $invoice->id)
        ->with('success', 'Invoice created successfully');
    } catch (\Throwable $e) {
      DB::rollBack();
      report($e);

      return back()->withInput()
        ->with('error', 'Something went wrong. Please try again.');
    }
  }

  public function download(CustomInvoice $invoice)
  {
    $pdf = PDF::loadView('company.custom_invoices.pdf', compact('invoice'));
    return $pdf->download($invoice->invoice_no . '.pdf');
  }


  public function payupdate(Request $request, $id)
  {
    $invoice = CustomInvoice::where('id', $id)->first();
    $invoice->status = 'paid';
    $invoice->save();
    return redirect()
      ->back()
      ->with('success', 'Invoice updated successfully');
  }

  public function destroy($id)
  {
       CustomInvoice::where('id', $id)->delete();
           return redirect()
      ->back()
      ->with('success', 'Invoice deleted successfully');
  }
}
