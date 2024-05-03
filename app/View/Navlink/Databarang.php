
<div class="container text-center rounded">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary d-inline-block">
    <a class="navbar-brand" href="#">Toko Matahari</a><br>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/navlink/barang">Data Barang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/navlink/pelanggan">Pelanggan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="logout" href="/users/logout" >Logout</a>
        </li>
      </ul>
    </div>
  </nav>
</div>



    
    <div class="container">
    <div>
                
                <?php 
                if(isset($model['error'])):
                 ?>
                    <div class="alert alert-danger" role="alert"><?php echo $model['error']; ?></div>
                <?php endif ?>
            </div>
            <div class="container mt-4">
     <div class="row">
    <div class="col-md-6 offset-md-3">
      <form action="/navlink/barang" method="GET">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Cari..." name="query">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">Cari</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

        <h1 class="text-center"><?php echo $model['title'] ?></h1>
        <div class="mx-auto">

            <button type="submit" name="tambah" class="btn-primary mb-2 rounded-3" id="viewtambah">tambah</button>
        </div>
      
    
        
        <div id="formTambah">
        </div>

      
       

        
        <table class="table rounded-md">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">ID Barang</th>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Jenis Barang</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
           
            <?php foreach ($model['barangData'] as $barang): ?>
        <tr>
            <td><?php echo $barang['id']; ?></td>
            <td><?php echo $barang['nama']; ?></td>
            <td><?php echo $barang['jenis']; ?></td>
            <td>        <!-- Tombol Edit -->
                        <a href="/edit?id=<?= $barang['id'] ?>" class="btn btn-info mb-sm-0 mb-1">Edit</a>
                        <!-- Tombol Delete -->
                        <button type="button" id="delete" class="btn btn-danger delete-btn" data-id="<?= $barang['id'] ?>">Delete</button>

                    </td>

        </tr>
        <?php endforeach; ?>
        <div class="pagination justify-content-center mb-4">
    <?php
    $totalPages = ceil($model['totalItem' ] / $model['limit']);
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $prevPage = max($currentPage - 1, 1);
    $nextPage = min($currentPage + 1, $totalPages);

    // Tombol halaman sebelumnya
    if ($currentPage > 1) {
        echo "<a class='page-link rounded-sm' href='?page=$prevPage'>&laquo; Previous</a> ";
    }

    // Tombol halaman
    for ($i = 1; $i <= $totalPages; $i++) {
        $active = $i == $currentPage ? 'active' : '';
        echo "<a class='page-link rounded-sm $active' href='?page=$i'>$i</a> ";
    }

    // Tombol halaman selanjutnya
    if ($currentPage < $totalPages) {
        echo "<a class='page-link rounded-sm' href='?page=$nextPage'>Next &raquo;</a> ";
    }
    ?>
</div>
                <!-- Add more data as needed -->
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="/js/script.js"></script>

 


    

    
