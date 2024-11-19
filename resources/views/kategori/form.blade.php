<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-title">Tambah Kategori</h5>
                </div>
                <div class="modal-body">
                    <!-- Input Nama Kategori -->
                    <div class="form-group">
                        <label for="nama_kategori" class="control-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required autofocus>
                        <span class="help-block with-errors"></span>
                    </div>

                    <!-- Dropdown untuk Memilih Ikon Font Awesome -->
                    <div class="form-group">
                        <label for="icon" class="control-label">Icon</label>
                        <select name="icon" id="icon" class="form-control" required>
                            <option value="">Pilih Icon</option>
                            <option value="fa fa-coffee">&#xf0f4; Coffee</option>
                            <option value="fa fa-bowl-food">&#xf0f5; Bowl Food</option>
                            <option value="fa fa-utensils">&#xf2e7; Utensils</option>
                            <option value="fa fa-egg">&#xf7fb; Egg</option>
                            <option value="fa fa-hamburger">&#xf805; Burger</option>
                            <option value="fa fa-bacon">&#xf7e5; Bacon</option>
                            <option value="fa fa-mug-hot">&#xf7b6; Mug Hot</option>
                            <option value="fa fa-lemon">&#xf094; Lemon</option>
                            <option value="fa fa-mug-saucer">&#xf0f4; Mug Saucer</option>
                            <option value="fa fa-seedling">&#xf4d8; Seedling</option>
                            <option value="fa fa-wine-bottle">&#xf72f; Wine Bottle</option>
                            <option value="fa fa-wine-glass">&#xf4e3; Wine Glass</option>
                            <option value="fa fa-wheat-awn">&#xf7bf; Wheat Awn</option>
                            <option value="fa fa-stroopwafel">&#xf551; Stroopwafel</option>
                            <option value="fa fa-shrimp">&#xf9b0; Shrimp</option>
                            <option value="fa fa-plate-wheat">&#xf2e7; Plate Wheat</option>
                            <option value="fa fa-pizza-slice">&#xf818; Pizza Slice</option>
                            <option value="fa fa-pepper-hot">&#xf816; Pepper Hot</option>
                            <option value="fa fa-martini-glass">&#xf000; Martini Glass</option>
                            <option value="fa fa-jar">&#xf0c8; Jar</option>
                            <option value="fa fa-ice-cream">&#xf810; Ice Cream</option>
                            <option value="fa fa-hotdog">&#xf80f; Hotdog</option>
                            <option value="fa fa-glass-water">&#xf0b7; Glass Water</option>
                            <option value="fa fa-fish-fins">&#xf578; Fish Fins</option>
                            <option value="fa fa-drumstick-bite">&#xf6d7; Drumstick Bite</option>
                            <option value="fa fa-cookie">&#xf563; Cookie</option>
                            <option value="fa fa-cheese">&#xf7ef; Cheese</option>
                            <option value="fa fa-cake-candles">&#xf1fd; Cake Candles</option>
                            <option value="fa fa-bread-slice">&#xf7ec; Bread Slice</option>
                            <option value="fa fa-bowl-rice">&#xf2e3; Bowl Rice</option>
                            <option value="fa fa-bottle-water">&#xf0f1; Bottle Water</option>
                        </select>
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
