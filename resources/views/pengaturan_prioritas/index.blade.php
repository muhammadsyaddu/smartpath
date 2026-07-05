<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f4f4f4;">
            
            <th>Label</th>
            <th>Bobot Keparahan</th>
            <th>Bobot Pelapor</th>
            <th>Bobot Fasilitas</th>
            <th>Radius Deduplikasi</th>
            <th>Radius Fasilitas</th>
            <th>Catatan</th>
            <th>Berlaku Sejak</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($prioritas as $item)
        <tr>
            <td style="text-align: left; padding-left: 10px;">{{ $item->label }}</td>
            <td>{{ $item->bobot_keparahan }}</td>
            <td>{{ $item->bobot_pelapor }}</td>
            <td>{{ $item->bobot_fasilitas }}</td>
            <td>{{ $item->radius_deduplikasi_m }}m</td>
            <td>{{ $item->radius_fasilitas_m }}m</td>
            <td>{{ $item->catatan }}</td>
            <td>{{ $item->berlaku_sejak }}</td>
            <td>
                @if($item->adalah_aktif)
                    <span style="color: green; font-weight: bold;">Aktif</span>
                @else
                    <span style="color: gray;">Non Aktif</span>
                @endif
            </td>
            <td>
                @if(!$item->adalah_aktif)
                    <form action="{{ route('prioritas.activate', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Aktifkan</button>
                    </form>
                @endif
                <a href="{{ route('pengaturan_prioritas.edit', $item->id) }}">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>