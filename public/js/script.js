
function deleteData(id, path) {
  let deleteUrl = "";
  let redirectUrl = "";

  if (path === '/navlink/barang') {
      deleteUrl = `/delete?id=${id}`;
      redirectUrl = '/navlink/barang';
  } else if (path === '/navlink/pelanggan') {
      deleteUrl = `/deletepelanggan?id=${id}`;
      redirectUrl = '/navlink/pelanggan';
  }

  fetch(deleteUrl, {
      method: 'DELETE'
  })
  .then(response => {
      if (response.ok) {
          // Jika data berhasil dihapus, alihkan pengguna ke halaman sesuai dengan path
          window.location.href = redirectUrl;
      } else {
          throw new Error('Gagal menghapus data.');
      }
  })
  .catch(error => {
      console.error('Error:', error);
      // Tampilkan pesan error jika terjadi masalah saat mengirim permintaan DELETE
      Swal.fire("Gagal menghapus data", "", "error");
  });
}

// Gunakan fungsi deleteData dengan path yang sesuai



if(window.location.pathname === '/navlink/pelanggan' || window.location.pathname === '/navlink/barang' ){
    // script untuk menghapus Data

    document.addEventListener('DOMContentLoaded', function() {
      // Menambahkan event listener untuk klik pada tombol "Delete"
      let deleteButtons = document.querySelectorAll('.delete-btn');
      deleteButtons.forEach(function(button) {
          button.addEventListener('click', function(event) {
              event.preventDefault(); // Mencegah perilaku default tombol
  
              const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                      confirmButton: "btn btn-success",
                      cancelButton: "btn btn-danger"
                  },
                  buttonsStyling: false
              });
  
              // Menampilkan konfirmasi SweetAlert
              swalWithBootstrapButtons.fire({
                  title: "Apakah Anda yakin?",
                  text: "Anda tidak akan dapat mengembalikan ini!",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonText: "Ya, hapus!",
                  cancelButtonText: "Tidak, batalkan!",
                  reverseButtons: true,
                  cancelButton:"swal2-cancel"
                
              }).then((result) => {
                  if (result.isConfirmed) {
                      // Jika pengguna menekan "Ya, Hapus", lanjutkan dengan penghapusan
                      let id = button.dataset.id;
                      let path = window.location.pathname;
                      Swal.fire("Data Berhasil Dihapus", "", "success").then(() => {
                          // Memanggil fungsi untuk menghapus barang setelah SweetAlert dikonfirmasi
                         deleteData(id, path)
                          
                      
                      });
                  }
              });
          });
      });
  
    
  
    });


    

let tambahitem = document.getElementById("viewtambah");

tambahitem.addEventListener("click", function() {
  let formTambah = document.getElementById("formTambah");

  // Bersihkan formTambah sebelum menambahkan elemen baru
  formTambah.innerHTML = "";

  console.log(formTambah);

  let actionUrl = ""; // Action URL
  let idCapt = ""; // Caption for ID field
  let nameCapt = ""; // Caption for name field
  let alamatCapt = ""; // Caption for alamat field
  let nohpCapt = ""; // Caption for no_hp field
  let idName = ""; // Name for ID field
  let nameName = ""; // Name for name field
  let alamatName = ""; // Name for alamat field
  let nohpName = ""; // Name for no_hp field
  let btnCapt = "";

  // Periksa jika path saat ini adalah /navlink/barang
  if (window.location.pathname === "/navlink/barang") {
      actionUrl = "/navlink/barang";
      idCapt = "ID Barang";
      nameCapt = "Nama Barang";
      jenisCapt = "Jenis Barang";
      idName = "id_barang";
      nameName = "nama_barang";
      jenisName = "jenis_barang";
      btnCapt = "Barang"
      
  } 
  if (window.location.pathname === "/navlink/pelanggan") {
      actionUrl = "/navlink/pelanggan";
      idCapt = "ID Pelanggan";
      nameCapt = "Nama Pelanggan";
      alamatCapt = "Alamat";
      nohpCapt = "NO HP";
      idName = "id_pelanggan";
      nameName = "nama_pelanggan";
      alamatName = "alamat";
      nohpName = "no_hp";
      btnCapt = "Pelanggan"
  }
  let inputFields = [];

  // Konfigurasi input untuk /navlink/barang
  if (window.location.pathname === "/navlink/barang") {
      inputFields = [
          { name: idName, caption: idCapt, type: 'text' },
          { name: nameName, caption: nameCapt, type: 'text' },
          { name: jenisName, caption: jenisCapt, type: 'select' }
      ];
  }
  // Konfigurasi input untuk /navlink/pelanggan
  else if (window.location.pathname === "/navlink/pelanggan") {
      inputFields = [
          { name: idName, caption: idCapt, type: 'text' },
          { name: nameName, caption: nameCapt, type: 'text' },
          { name: alamatName, caption: alamatCapt, type: 'text' },
          { name: nohpName, caption: nohpCapt, type: 'text' }
      ];
  }
  
  let inputsHTML = "";
  
  inputFields.forEach((field, index) => {
      let inputElement = "";
  
      if (field.type === 'select') {
          inputElement = `
              <div class="form-group mt-n3">
                  <label for="Input${index}" class="form-label">${field.caption}:</label>
                  <select class="form-select" id="Input${index}" name="${field.name}">

                      <option value="" disabled selected>Pilih Jenis Barang</option>
                      <option value="makanan">Makanan</option>
                      <option value="minuman">Minuman</option>
                      <option value="accesories">Accesories</option>
                      <option value="lainnya">Lainnya</option>
                      <!-- Add more options as needed -->
                  </select>
              </div>
          `;
      } else {
          inputElement = `
              <div class="form-group mt-n3">
                  <label for="Input${index}" class="form-label">${field.caption}:</label>
                  <input type="${field.type}" class="form-control" id="Input${index}" name="${field.name}">
              </div>
          `;
      }
  
      inputsHTML += inputElement;
  });
  

  let formHTML = `
      <form action="${actionUrl}" method="post" id="formTambahItem" style="max-width: 400px;  margin: 0 auto;">
          ${inputsHTML}
          <button type="submit" id="tambah" class="btn btn-primary mt-2">Add ${btnCapt}</button>
      </form>
  `;

  
  // Tambahkan formHTML ke dalam formTambah
  formTambah.innerHTML = formHTML;

  function addbarang(){
    let formData = new FormData(document.getElementById('formTambahItem'));

    // Periksa apakah ada input dengan nilai kosong
    let isEmptyField = false;
    formData.forEach((value, key) => {
        if (value.trim() === '') {
            isEmptyField = true;
            return;
        }
    });

    if (isEmptyField) {
        // Tampilkan pesan kesalahan jika ada input dengan nilai kosong
        Swal.fire("Gagal", "Semua input kolom harus diisi", "error");
        return;
    }

    fetch(actionUrl, {
      method: 'POST',
      body: formData
     

    })
    .then(response => {
      if (response.ok) {
        Swal.fire("Data Berhasil Ditambahkan", "", "success").then(() =>{
          window.location.href = window.location.pathname;
        })
      } 
      else if (response.status === 409) {
        // Tangani kesalahan konflik id
        return response.json().then(data => {
            throw new Error(data.message);
        });
    }
      
      else {
        throw new Error('Data Gagal Ditambahkan');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      // Show error message to the user
      Swal.fire("Gagal", error.message, "error");
    });
  }



  document.getElementById('tambah').addEventListener('click', function(e){
    e.preventDefault();
   addbarang();
  })
});
}




// logout script

  document.getElementById('logout').addEventListener('click', function(e) {
    e.preventDefault();
    
    Swal.fire({
      title: 'Anda yakin ingin logout?',
      text: 'Anda akan keluar dari sesi Anda.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Logout',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        logout();
      }
    });
  });
  
  function logout() {
    fetch(`/users/logout`, {
      method: 'GET'
    })
    .then(response => {
      if (response.ok) {
        Swal.fire("Berhasil Logout", "", "success").then(() =>{
          window.location.href = '/';
        })
  
      
      } else {
        throw new Error('Logout failed');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      // Show error message to the user
      Swal.fire("Failed to logout", "", "error");
    });
  }
  





