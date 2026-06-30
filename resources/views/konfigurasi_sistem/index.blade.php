<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Konfigurasi Sistem</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 8px; }
    </style>
</head>
<body>
    <h2>Kelola Konfigurasi Sistem</h2>
    
    @if (session('success'))
       <div class="alert alert-success">
           {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kunci</th>
                <th>Nilai</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
           @foreach($konfigurasi as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kunci }}</td>
                <td>{{ $item->nilai }}</td>
                <td>{{ $item->deskripsi }}</td>
                
                <td>
                    <a href="{{ route('konfigurasi_sistem.edit', $item->konfigurasi_id) }}">Edit</a>
                    @if ($errors->any())
                    <div style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif  
                    <form action="{{ route('konfigurasi_sistem.destroy', $item->konfigurasi_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Apakah anda yakin ingin menghapus konfigurasi ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
           @endforeach
        </tbody>
    </table>
</body>
</html>