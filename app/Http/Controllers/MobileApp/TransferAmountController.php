<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferAmountRequest;
use App\Models\TransferAmount;
use Illuminate\Http\Request;

class TransferAmountController extends Controller
{
    public function index()
    {
        $items = TransferAmount::with(['user','company'])
            ->latest()
            ->paginate(20);

        return view('company.mobile-app.transfer.index', compact('items'));
    }


    public function create()
    {
        return view('admin.transfer.form');
    }


    public function store(TransferAmountRequest $request)
    {
        TransferAmount::create([
            ...$request->validated(),
            'transferred_by' => auth()->id(),
        ]);

        return back()->with('success', 'Transfer request created successfully.');
    }


    public function edit($id)
    {
        $item = TransferAmount::findOrFail($id);
        return view('admin.transfer.form', compact('item'));
    }


    public function update(TransferAmountRequest $request, $id)
    {
        $item = TransferAmount::findOrFail($id);
        $item->update($request->validated());

        return back()->with('success', 'Transfer updated successfully.');
    }


    public function approve($id)
    {
        $item = TransferAmount::findOrFail($id);

        $item->update([
            'status'      => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Transfer approved.');
    }

    public function destroy($id)
    {
        TransferAmount::destroy($id);
        return back()->with('success', 'Transfer deleted.');
    }
}
