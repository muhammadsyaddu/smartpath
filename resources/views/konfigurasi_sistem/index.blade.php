<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Konfigurasi Sistem</title>
</head>
<body>

    <h1>Pengaturan Konfigurasi Sistem</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('konfigurasi_sistem.update') }}" method="POST">
        @csrf
        
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="text-align: left;">Keterangan</th>
                    <th style="text-align: left;">Nilai</th>
                    <th style="text-align: left;">Kunci</th>
                </tr>
            </thead>
            <tbody>
                @foreach($konfigurasis as $config)
                    @if($config->dapat_diedit_ui)
                        <tr>
                            <td>{{ $config->keterangan }}</td>
                            <td>
                                @if($config->tipe_nilai === 'boolean')
                                    <select name="config[{{ $config->kunci }}]">
                                        <option value="1" {{ $config->nilai == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ $config->nilai == '0' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                @else
                                    <input type="text" name="config[{{ $config->kunci }}]" value="{{ $config->nilai }}" style="width: 90%;">
                                @endif
                            </td>
                            <td><code>{{ $config->kunci }}</code></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <button type="submit" style="padding: 10px 20px;">Simpan Perubahan</button>
        </div>
    </form>

</body>
</html>