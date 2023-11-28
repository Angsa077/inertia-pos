<div class="title" style="padding-bottom: 13px">
    <div style="text-align: center;text-transform: uppercase;font-size: 15px">
        Angsa77
    </div>
    <div style="text-align: center">
        Alamat: Serang, Banten, Indonesia.
    </div>
    <div style="text-align: center">
        Telp: 0877-4100-1100
    </div>
</div>
<table style="width: 100%">
    <thead>
        <tr style="background-color: #e6e6e7;">
            <th scope="col">Date</th>
            <th scope="col">Invoice</th>
            <th scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($profits as $profit)
        <tr>
            <td>{{ $profit->created_at }}</td>
            <td>{{ $profit->transaction->invoice }}</td>
            <td class="text-end">{{ formatPrice($profit->total) }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" class="text-end fw-bold" style="background-color: #e6e6e7;">TOTAL</td>
            <td class="text-end fw-bold" style="background-color: #e6e6e7;">{{ formatPrice($total) }}</td>
        </tr>
    </tbody>
</table>