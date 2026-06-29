<h2>Edit Konfigurasi Sistem</h2>
<form action="{{ route('konfigurasi_sistem.update', $konfigurasi->konfigurasi_id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="kunci">Kunci:</label>
    <input type="text" id="kunci" name="kunci" value="{{ $konfigurasi->kunci }}" required><br><br>

    <label for="nilai">Nilai:</label>
    <input type="text" id="nilai" name="nilai" value="{{ $konfigurasi->nilai }}" required><br><br>

    <label for="deskripsi">Deskripsi:</label>
    <textarea id="deskripsi" name="deskripsi" required>{{ $konfigurasi->deskripsi }}</textarea><br><br>

    <button type="submit">Simpan Perubahan</button>