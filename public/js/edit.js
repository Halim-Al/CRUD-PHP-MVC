    // script untuk edit data

    document.getElementById('edit').addEventListener('click', function(event){

        event.preventDefault(); // Menghentikan pengiriman formulir secara otomatis
      
        Swal.fire({
            title: "Apakah anda yakin data akan diubah?",
            icon: "question",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "yakin",
            denyButtonText: `tidak`
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                // Jika pengguna memilih untuk menyimpan, alihkan halaman setelah menampilkan pesan sukses
                Swal.fire("Data Diupdate!", "", "success").then(() => {
                    sendForm();
                });
            } else if (result.isDenied) {
                // Jika pengguna memilih untuk tidak menyimpan, tampilkan pesan informasi dan tidak melakukan pengalihan
                Swal.fire("Data Tidak Diupdate", "", "info");
            }
        });
      });
      
      function sendForm() {
        // Dapatkan URL yang ditetapkan dalam atribut action formulir
        let formAction = document.querySelector('form').getAttribute('action');
        // Dapatkan data formulir
        let formData = new FormData(document.querySelector('form'));
        
        // Kirim permintaan POST menggunakan Fetch API
        fetch(formAction, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                // Jika data berhasil diperbarui, alihkan pengguna ke halaman /update
                if (window.location.pathname === '/edit') {
                    // Lakukan sesuatu di sini
                    window.location.href = '/navlink/barang';
                }
                if (window.location.pathname === '/editpelanggan') {
                    // Lakukan sesuatu di sini
                    window.location.href = '/navlink/pelanggan';
                }
            } else {
                throw new Error('Failed to update data.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Tampilkan pesan error jika terjadi masalah saat mengirim permintaan POST
            Swal.fire("Failed to update data", "", "error");
        });
      }
      
      