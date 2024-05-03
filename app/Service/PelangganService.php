<?php 
namespace Halim\CrudMvc\Service;

use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Domain\Pelanggan;
use Halim\CrudMvc\Repository\PelangganRepository;
use Halim\CrudMvc\Model\PelangganRequest;
use Halim\CrudMvc\Exception\ValidationException;
use Halim\CrudMvc\Model\PelangganResponse;

class PelangganService{
    private PelangganRepository $pelangganRepository;

    public function __construct(PelangganRepository $pelangganRepository)
    {
        $this->pelangganRepository = $pelangganRepository;
    }

    public function addPelanggan(PelangganRequest $request): PelangganResponse
    {
        $this->validatePelangganRequest($request);

        
        try {
            Database::beginTransaction();
            $pelanggan = $this->pelangganRepository->findById($request->id_pelanggan);
            if ($pelanggan != null) {
               // Kembalikan respon dengan status 409 (konflik) dan pesan kesalahan
               http_response_code(409);
               echo json_encode(['message' => 'Id Pelanggan sudah ada']);
               exit();
            }

            $pelanggan = new Pelanggan();
            $pelanggan->id_pelanggan = $request->id_pelanggan;
            $pelanggan->nama_pelanggan = $request->nama_pelanggan;
            $pelanggan->alamat = $request->alamat;
            $pelanggan->no_hp = $request->no_hp;

            $this->pelangganRepository->save($pelanggan);

            $response = new PelangganResponse();
            $response->pelanggan = $pelanggan;

            Database::commitTransaction();
            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    
    public function updatepelanggan(PelangganRequest $request): PelangganResponse
    {
        $this->validateUpdateRequest($request);

        
        try {
            Database::beginTransaction();
            $barang = $this->pelangganRepository->findById($request->id_pelanggan);
            if ($barang == null) {
                throw new ValidationException("Barang Id not exists");
            }

            $pelanggan = new Pelanggan();
            $pelanggan->id_pelanggan = $request->id_pelanggan;
            $pelanggan->nama_pelanggan = $request->nama_pelanggan;
            $pelanggan->alamat = $request->alamat;
            $pelanggan->no_hp = $request->no_hp;

            $this->pelangganRepository->update($pelanggan);

            $response = new PelangganResponse();
            $response->pelanggan = $pelanggan;

            Database::commitTransaction();
            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    public function deletePelanggan(string $id): void
    {
        try {
            Database::beginTransaction();
            
            // Validasi permintaan
            $this->validateDeleteRequest($id);
    
            // Temukan barang berdasarkan ID
            $pelanggan = $this->pelangganRepository->findById($id);
            if ($pelanggan == null) {
                throw new ValidationException("Barang ID not exists");
            }
    
            // Hapus barang dari database
            $this->pelangganRepository->deleteById($id);
    
            Database::commitTransaction();
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    private function validateUpdateRequest(PelangganRequest $request)
    {
        if ($request->id_pelanggan == null || $request->nama_pelanggan == null || $request->alamat == null ||  $request->no_hp == null ||
            trim($request->id_pelanggan) == "" || trim($request->nama_pelanggan) == "" || trim($request->alamat) == "" || trim($request->no_hp) == "") {
                throw new ValidationException("Id, Nama, alamat dan No HP can not blank");
            }
    }

    private function validatePelangganRequest(PelangganRequest $request)
    {
        if ($request->id_pelanggan == null || $request->nama_pelanggan == null || $request->alamat == null ||  $request->no_hp == null ||
            trim($request->id_pelanggan) == "" || trim($request->nama_pelanggan) == "" || trim($request->alamat) == "" || trim($request->no_hp) == "") {
            throw new ValidationException("Id, Nama, alamat dan No HP can not blank");
        }
    }

    private function validateDeleteRequest(string $id): void
{
    // Validasi ID barang
    $id_barang = $id;
    if ($id_barang === null || !is_numeric($id_barang)) {
        throw new ValidationException("Invalid barang ID");
    }
    // Anda dapat menambahkan validasi lain sesuai kebutuhan, misalnya validasi apakah ID barang ada dalam format yang benar, dll.
}


public function searchbarang(PelangganRequest $request){
         
    Database::beginTransaction();
    $barang = $this->pelangganRepository->getDatasearch($request->id_pelanggan, $request->nama_pelanggan, $request->alamat, $request->no_hp);
    if ($barang === null) {
        // Kembalikan respon dengan status 409 (konflik) dan pesan kesalahan
        http_response_code(408);
        echo json_encode(['message' => 'barang tidak ditemukan']);
        exit();
    }
    return $barang;

}

}

?>