<?php 
namespace Halim\CrudMvc\Service;

use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Domain\Barang;
use Halim\CrudMvc\Repository\BarangRepository;
use Halim\CrudMvc\Model\BarangRequest;
use Halim\CrudMvc\Exception\ValidationException;
use Halim\CrudMvc\Model\BarangResponse;

class BarangService{
    private BarangRepository $barangRepository;

    public function __construct(BarangRepository $barangRepository)
    {
        $this->barangRepository = $barangRepository;
    }

    public function addbarang(BarangRequest $request): BarangResponse
    {
        $this->validateBarangRequest($request);

        
        try {
            Database::beginTransaction();
            $barang = $this->barangRepository->findById($request->id_barang);
            if ($barang != null) {
                // Kembalikan respon dengan status 409 (konflik) dan pesan kesalahan
                http_response_code(409);
                echo json_encode(['message' => 'Id Barang sudah ada']);
                exit();
            }

            $barang = new Barang();
            $barang->id_barang = $request->id_barang;
            $barang->nama_barang = $request->nama_barang;
            $barang->jenis_barang = $request->jenis_barang;

            $this->barangRepository->save($barang);

            $response = new BarangResponse();
            $response->barang = $barang;

            Database::commitTransaction();
            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    public function searchbarang(BarangRequest $request){
       
            Database::beginTransaction();
            $barang = $this->barangRepository->getDatasearch($request->id_barang, $request->nama_barang, $request->jenis_barang);
            if ($barang === null) {
                // Kembalikan respon dengan status 409 (konflik) dan pesan kesalahan
                http_response_code(408);
                echo json_encode(['message' => 'barang tidak ditemukan']);
                exit();
            }
            return $barang;
       
    }
    

    public function updatebarang(BarangRequest $request): BarangResponse
    {
        $this->validateUpdateRequest($request);

        
        try {
            Database::beginTransaction();
            $barang = $this->barangRepository->findById($request->id_barang);
            if ($barang == null) {
                throw new ValidationException("Barang Id not exists");
            }

            $barang = new Barang();
            $barang->id_barang = $request->id_barang;
            $barang->nama_barang = $request->nama_barang;
            $barang->jenis_barang = $request->jenis_barang;

            $this->barangRepository->update($barang);

            $response = new BarangResponse();
            $response->barang = $barang;

            Database::commitTransaction();
            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }


    public function deleteBarang(string $id): void
{
    try {
        Database::beginTransaction();
        
        // Validasi permintaan
        $this->validateDeleteRequest($id);

        // Temukan barang berdasarkan ID
        $barang = $this->barangRepository->findById($id);
        if ($barang == null) {
            throw new ValidationException("Barang ID not exists");
        }

        // Hapus barang dari database
        $this->barangRepository->deleteById($id);

        Database::commitTransaction();
    } catch (\Exception $exception) {
        Database::rollbackTransaction();
        throw $exception;
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
    private function validateBarangRequest(BarangRequest $request)
    {
        if ($request->id_barang == null || $request->nama_barang == null || $request->jenis_barang == null ||
            trim($request->id_barang) == "" || trim($request->nama_barang) == "" || trim($request->jenis_barang) == "") {
            throw new ValidationException("Id, Nama, jenis can not blank");
        }
    }

    
    private function validateUpdateRequest(BarangRequest $request)
    {
        if ($request->id_barang == null || $request->nama_barang == null || $request->jenis_barang == null ||
            trim($request->id_barang) == "" || trim($request->nama_barang) == "" || trim($request->jenis_barang) == "") {
            throw new ValidationException("Id, Nama, jenis can not blank");
        }
    }

}

?>