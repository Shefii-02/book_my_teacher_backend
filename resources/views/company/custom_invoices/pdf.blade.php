@foreach($invoice->items as $item)
<tr>
<td>{{ $item->title }}</td>
<td>{{ $item->quantity }}</td>
<td class="text-right">{{ $item->total }}</td>
</tr>
@endforeach
