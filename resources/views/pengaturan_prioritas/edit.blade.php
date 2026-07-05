<form action="{{ route('pengaturan_prioritas.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div style="margin-bottom: 15px;">
        <label>Label:</label><br>
        <input type="text" name="label" value="{{ $item->label }}" required style="width: 100%;">
    </div>

    <div style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label>B. Keparahan:</label><br>
            <input type="number" name="bobot_keparahan" value="{{ $item->bobot_keparahan }}" step="0.01" required>
        </div>
        <div style="flex: 1;">
            <label>B. Pelapor:</label><br>
            <input type="number" name="bobot_pelapor" value="{{ $item->bobot_pelapor }}" step="0.01" required>
        </div>
        <div style="flex: 1;">
            <label>B. Fasilitas:</label><br>
            <input type="number" name="bobot_fasilitas" value="{{ $item->bobot_fasilitas }}" step="0.01" required>
        </div>
    </div>

    <div style="display: flex; gap: 10px; margin-top: 15px;">
        <div style="flex: 1;">
            <label>Radius Dedup (m):</label><br>
            <input type="number" name="radius_deduplikasi_m" value="{{ $item->radius_deduplikasi_m }}" required>
        </div>
        <div style="flex: 1;">
            <label>Radius Fasilitas (m):</label><br>
            <input type="number" name="radius_fasilitas_m" value="{{ $item->radius_fasilitas_m }}" required>
        </div>
    </div>

    <div style="margin-top: 15px;">
        <label>Catatan:</label><br>
        <textarea name="catatan" style="width: 100%;" rows="3">{{ $item->catatan }}</textarea>
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" style="padding: 10px 20px; background-color: blue; color: white; border: none; cursor: pointer;">
            Simpan Perubahan
        </button>
        <a href="{{ route('prioritas.index') }}">Batal</a>
    </div>
</form>