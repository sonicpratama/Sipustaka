@extends('layouts.app')
@section('title', 'Peminjaman')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h4 class="mb-0"><i class="bi bi-journal-arrow-up"></i> Data Peminjaman</h4>
    <button type="button" class="btn btn-primary" id="btnTambah"><i class="bi bi-plus-lg"></i> Tambah Peminjaman</button>
</div>

<div id="alertBox"></div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:50px">No</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Bukti</th>
                    <th class="text-end" style="width:120px">Aksi</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <tr><td colspan="8" class="text-center text-muted py-4">Memuat data...</td></tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Modal tambah / ubah --}}
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" id="formPeminjaman" enctype="multipart/form-data" novalidate>
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="judul_buku" class="form-control" list="listBuku" autocomplete="off">
                    <datalist id="listBuku">
                        @foreach ($daftarBuku as $judul)
                            <option value="{{ $judul }}">
                        @endforeach
                    </datalist>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Dipinjam">Dipinjam</option>
                        <option value="Dikembalikan">Dikembalikan</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-1">
                    <label class="form-label">Foto Bukti Peminjaman <small class="text-muted">(jpg/png/pdf, maks 2 MB)</small></label>
                    <input type="file" name="bukti" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    <div class="invalid-feedback"></div>
                    <div id="currentFile" class="form-text"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="btnSimpan"><i class="bi bi-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
(() => {
    const base  = "{{ url('peminjaman') }}";
    const csrf  = document.querySelector('meta[name="csrf-token"]').content;
    const form  = document.getElementById('formPeminjaman');
    const modal = new bootstrap.Modal(document.getElementById('modalForm'));
    const headers = {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrf,
    };
    let editId = null;

    const esc = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

    function showAlert(message, type = 'success') {
        const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';
        document.getElementById('alertBox').innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show">
                <i class="bi bi-${icon} me-1"></i> ${esc(message)}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
    }

    function clearErrors() {
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    }

    function showErrors(errors) {
        Object.entries(errors).forEach(([field, messages]) => {
            const input = form.querySelector(`[name="${field}"]`);
            if (!input) return;
            input.classList.add('is-invalid');
            input.parentElement.querySelector('.invalid-feedback').textContent = messages[0];
        });
    }

    async function loadData() {
        const res  = await fetch(`${base}/data`, { headers });
        const rows = await res.json();
        const tbody = document.getElementById('tbody');

        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted py-4">Belum ada data peminjaman.</td></tr>';
            return;
        }

        tbody.innerHTML = rows.map((r, i) => `
            <tr>
                <td>${i + 1}</td>
                <td class="fw-semibold">${esc(r.nama_peminjam)}</td>
                <td>${esc(r.judul_buku)}</td>
                <td>${esc(r.tanggal_pinjam)}</td>
                <td>${esc(r.tanggal_kembali)}</td>
                <td><span class="badge ${r.status === 'Dipinjam' ? 'bg-warning text-dark' : 'bg-success'}">${esc(r.status)}</span></td>
                <td>${r.bukti_url
                    ? `<a href="${esc(r.bukti_url)}" target="_blank" rel="noopener"><i class="bi bi-paperclip"></i> Lihat</a>`
                    : '<span class="text-muted">-</span>'}</td>
                <td class="text-end">
                    <button class="btn btn-sm btn-warning" data-edit="${r.id}"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-danger" data-delete="${r.id}"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`).join('');
    }

    // Tambah
    document.getElementById('btnTambah').addEventListener('click', () => {
        editId = null;
        form.reset();
        clearErrors();
        document.getElementById('modalTitle').textContent = 'Tambah Peminjaman';
        document.getElementById('currentFile').innerHTML = '';
        modal.show();
    });

    // Ubah & hapus (delegasi event)
    document.getElementById('tbody').addEventListener('click', async (e) => {
        const btnEdit = e.target.closest('[data-edit]');
        const btnDel  = e.target.closest('[data-delete]');

        if (btnEdit) {
            const res  = await fetch(`${base}/${btnEdit.dataset.edit}`, { headers });
            const data = await res.json();
            editId = data.id;
            form.reset();
            clearErrors();
            ['nama_peminjam', 'judul_buku', 'tanggal_pinjam', 'tanggal_kembali', 'status'].forEach(f => {
                form.querySelector(`[name="${f}"]`).value = data[f] ?? '';
            });
            document.getElementById('modalTitle').textContent = 'Ubah Peminjaman';
            document.getElementById('currentFile').innerHTML = data.bukti_url
                ? `Berkas saat ini: <a href="${esc(data.bukti_url)}" target="_blank" rel="noopener">lihat</a>. Pilih berkas baru untuk menggantinya.`
                : 'Belum ada berkas.';
            modal.show();
        }

        if (btnDel && confirm('Yakin ingin menghapus data peminjaman ini?')) {
            const res  = await fetch(`${base}/${btnDel.dataset.delete}`, { method: 'DELETE', headers });
            const json = await res.json();
            showAlert(json.message, res.ok ? 'success' : 'danger');
            loadData();
        }
    });

    // Simpan (tambah / ubah)
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors();

        const fd = new FormData(form);
        let url = base;
        if (editId) {
            url = `${base}/${editId}`;
            fd.append('_method', 'PUT'); // multipart tidak mendukung PUT langsung
        }

        const btn = document.getElementById('btnSimpan');
        btn.disabled = true;

        try {
            const res  = await fetch(url, { method: 'POST', headers, body: fd });
            const json = await res.json();

            if (res.status === 422) {          // error validasi dari Form Request
                showErrors(json.errors);
                return;
            }
            if (!res.ok) {
                showAlert(json.message || 'Terjadi kesalahan pada server.', 'danger');
                return;
            }

            modal.hide();
            showAlert(json.message);
            loadData();
        } finally {
            btn.disabled = false;
        }
    });

    loadData();
})();
</script>
@endpush
