<div class="container mt-5">
        <div class="row justify-content-center">
            <div>
                
                <?php 
                if(isset($model['error'])):
                 ?>
                    <div class="alert alert-danger" role="alert"><?php echo $model['error']; ?></div>
                <?php endif ?>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <?php 
                        echo $model['title'];
                        ?>
                    </div>
                    <div class="card-body">
                        <form action="/users/register" method="post">
                            <div class="form-group">
                                <label for="id">ID:</label>
                                <input type="text" id="id" name="id" class="form-control" value=<?= $_POST['id'] ?? '' ?> >
                            </div>

                            <div class="form-group">
                                <label for="nama">Nama:</label>
                                <input type="text" id="name" name="name" class="form-control" value=<?= $_POST['name'] ?? '' ?>>
                            </div>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" >
                            </div>

                            <button type="submit" class="btn btn-primary btn-block mt-2">Daftar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>