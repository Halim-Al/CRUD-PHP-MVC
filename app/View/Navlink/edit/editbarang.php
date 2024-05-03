<div class="container">
<?php if(isset($model['error'])) { ?>
        <div class="row">
            <div class="alert alert-danger" role="alert">
                <?= $model['error'] ?>
            </div>
        </div>
    <?php } ?>
    <h2>Edit Barang</h2>
    <form action="/update" id="form" method="POST">
        <div class="form-group">
            <label for="id_barang">ID Barang:</label>
            <input type="text" class="form-control" id="id_barang" name="id_barang" value=<?= $model['id'] ?> readonly >
        </div>
        <div class="form-group">
            <label for="nama_barang">Nama Barang:</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value=<?= $model['nama'] ?>>
        </div>
        <div class="form-group">
            <label for="jenis_barang">Jenis Barang:</label>
            <select class="form-select" id="jenis_barang" name="jenis_barang" value=<?= $model['jenis'] ?>>

                <option value="" disabled selected>Pilih Jenis Barang</option>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
                <option value="accesories">Accesories</option>
                <option value="lainnya">Lainnya</option>
                <!-- Add more options as needed -->
                </select>
        </div>
        <button type="submit"  id="edit" class="btn btn-primary mt-2">Update</button>
    </form>
</div>

<script src="/js/edit.js" defer></script>



