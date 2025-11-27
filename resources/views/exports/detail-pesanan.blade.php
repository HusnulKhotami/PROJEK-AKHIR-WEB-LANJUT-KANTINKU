<table>
    <thead>
        <tr>
            <th colspan="4">
                <strong>DETAIL PESANAN #{{ $pesanan->id }}</strong>
            </th>
        </tr>
        <tr>
            <th><strong>Pedagang:</strong></th>
            <th colspan="3">{{ $pesanan->pedagang->nama_kantin }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th>Nama Menu</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pesanan->items as $item)
        <tr>
            <td>{{ $item->menu->nama }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ $item->harga }}</td>
            <td>{{ $item->subtotal }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">Tidak ada item</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"><strong>Subtotal:</strong></td>
            <td><strong>{{ $pesanan->total_harga }}</strong></td>
        </tr>
        <tr>
            <td colspan="3"><strong>Tax (0%):</strong></td>
            <td><strong>0</strong></td>
        </tr>
        <tr>
            <td colspan="3"><strong>TOTAL:</strong></td>
            <td><strong>{{ $pesanan->total_harga }}</strong></td>
        </tr>
    </tfoot>
</table>
