<h2>Edit Prioritas</h2>
<form action="{{ route('pengaturan_prioritas.update', $prioritas->prioritas_id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="nama_prioritas">Nama Prioritas:</label>
    <input type="text" id="nama_prioritas" name="nama_prioritas" value="{{ $prioritas->nama_prioritas }}" required><br><br>

    <label for="bobot">Bobot Nilai:</label>
    <input type="number" step="0.01" id="bobot" name="bobot" value="{{ $prioritas->bobot }}" required><br><br>

    <label for="deskripsi">Deskripsi:</label>
    <textarea id="deskripsi" name="deskripsi">{{ $prioritas->deskripsi }}</textarea><br><br>

    <button type="submit">Simpan Perubahan</button>
</form>