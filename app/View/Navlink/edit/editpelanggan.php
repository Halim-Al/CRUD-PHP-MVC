<div class="container">
<?php if(isset($model['error'])) { ?>
        <div class="row">
            <div class="alert alert-danger" role="alert">
                <?= $model['error'] ?>
            </div>
        </div>
    <?php } ?>
    <h2>Edit pelanggan</h2>
    <form action="/updatepelanggan" id="form" method="POST">
        <div class="form-group">
            <label for="id_pelanggan">ID pelanggan:</label>
            <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan" value=<?= $model['id'] ?> readonly >
        </div>
        <div class="form-group">
            <label for="nama_pelanggan">Nama pelanggan:</label>
            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value=<?= $model['nama'] ?>>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value=<?= $model['alamat'] ?>>
        </div>
        <div class="form-group">
            <label for="no_hp">NO HP:</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" value=<?= $model['no_hp'] ?>>
        </div>
        <button type="submit" id="edit" class="btn btn-primary mt-2">Update</button>
    </form>
</div>

<script src="/js/edit.js" defer></script>



