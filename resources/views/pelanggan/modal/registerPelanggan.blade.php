<!-- Modal Register -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrasi Pelanggan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('customer.register') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nama *</label>
                        <input type="text" name="name" class="form-control" required placeholder="Nama lengkap">
                    </div>

                    <div class="mb-3">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" required placeholder="Email valid">
                    </div>

                    <div class="mb-3">
                        <label>Password *</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Konfirmasi Password *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>No. Telepon *</label>
                        <input type="text" name="phone" class="form-control" required placeholder="08xxxx">
                    </div>

                    <div class="mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Alamat Utama *</label>
                        <input type="text" name="address1" id="address1" class="form-control" required>
                        <small class="text-muted">Bisa pilih dari Maps nanti 🔥</small>
                    </div>

                    <div class="mb-3">
                        <label>Alamat Tambahan</label>
                        <input type="text" name="address2" class="form-control">
                    </div>

                    <input type="hidden" name="lat" id="lat">
                    <input type="hidden" name="lng" id="lng">

                </div>

                <div class="modal-footer d-grid gap-2">
                    <button type="submit" class="btn btn-success">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</div>
