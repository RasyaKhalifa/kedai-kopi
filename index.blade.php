<table class="table">
    <tr>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Harga</th>
    </tr>
    @foreach($menus as $menu)
    <tr>
        <td>{{$menu->nama}}</td>
        <td>{{$menu->kategori}}</td>
        <td>Rp {{number_format($menu->harga)}}</td>
    </tr>
    @endforeach
</table>
@foreach($mejas as $meja)
<tr>
    <td>{{ $meja->nomor_meja }}</td>
    <td>
        {!! QrCode::size(150)->generate(url('/meja/'.$meja->id)) !!}
    </td>
</tr>
@endforeach
