<?php 

namespace Halim\CrudMvc\Repository;

use Halim\CrudMvc\Domain\Barang;
use PHPUnit\Framework\TestCase;
use Halim\CrudMvc\Config\Database;

class BarangRepositoryTest extends TestCase{

    private BarangRepository $barangRepository;

    public function setUp() :void{
        $this->barangRepository = new BarangRepository(Database::getConnection());
        $this->barangRepository->deleteAll();
    }
    
    public function testSaveSuccess()
    {
        $barang = new Barang();
        $barang->id_barang = "1";
        $barang->nama_barang = "indomie";
        $barang->jenis_barang = "mie instan";

        $this->barangRepository->save($barang);

        $result = $this->barangRepository->findById($barang->id_barang);

        self::assertEquals($barang->id_barang, $result->id_barang);
        self::assertEquals($barang->nama_barang, $result->nama_barang);
        self::assertEquals($barang->jenis_barang, $result->jenis_barang);
    }

    public function testDeleteByIdSuccess()
    {
        $barang = new Barang();
        $barang->id_barang = "1";
        $barang->nama_barang = "converse";
        $barang->jenis_barang = "sepatu";
       

        $this->barangRepository->save($barang);

        $result = $this->barangRepository->findById($barang->id_barang);
        self::assertEquals($barang->id_barang, $result->id_barang);
        

        $this->barangRepository->deleteById($barang->id_barang);

        $result = $this->barangRepository->findById($barang->id_barang);
        self::assertNull($result);
    }

}

?>