@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
  <h2 class="text-xl font-bold mb-4">Trashed Coupons</h2>

  <table class="w-full border">
    <thead>
      <tr class="bg-gray-100">
        <th class="p-2 text-left">Name</th>
        <th class="p-2">Code</th>
        <th class="p-2">Deleted At</th>
        <th class="p-2">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($coupons as $coupon)
        <tr>
          <td class="p-2">{{ $coupon->offer_name }}</td>
          <td class="p-2">{{ $coupon->offer_code }}</td>
          <td class="p-2">{{ $coupon->deleted_at->format('d M Y H:i') }}</td>
          <td class="p-2">
            <form method="POST" action="{{ route('coupons.restore', $coupon->id) }}" class="inline">
              @csrf
              <button class="px-3 py-1 bg-green-500 text-white rounded">Restore</button>
            </form>
            <form method="POST" action="{{ route('coupons.forceDelete', $coupon->id) }}" class="inline">
              @csrf
              @method('DELETE')
              <button class="px-3 py-1 bg-red-500 text-white rounded">Delete Permanently</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
