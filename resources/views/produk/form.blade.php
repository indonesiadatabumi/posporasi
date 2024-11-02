<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-title">Tambah Produk</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_produk" class="control-label">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" required autofocus>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label for="id_kategori" class="control-label">Kategori</label>
                        <select name="id_kategori" id="id_kategori" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $key => $item)
                            <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label for="harga_beli" class="control-label">Modal</label>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control" required>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual" class="control-label">Harga Jual</label>
                        <input type="number" name="harga_jual" id="harga_jual" class="form-control" required>
                        <span class="help-block with-errors"></span>
                    </div>
                    {{-- <div class="form-group">
                        <label for="pajak" class="control-label">Pajak</label>
                        <input type="number" name="pajak" id="pajak" class="form-control" value="0">
                        <span class="help-block with-errors"></span>
                    </div> --}}
                    <div class="form-group">
                        <label for="stok" class="control-label">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" required value="0">
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class="control-label">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" class="form-control" >
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Produk:</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                        <img id="current-foto" src="" alt="Current Foto" class="mt-2" style="max-width: 100px; display: none;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
