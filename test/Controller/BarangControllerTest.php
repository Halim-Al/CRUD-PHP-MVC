<?php 

namespace Halim\CrudMvc\Controller;

use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Domain\Barang;
use Halim\CrudMvc\Model\BarangRequest;
use Halim\CrudMvc\Repository\BarangRepository;
use Halim\CrudMvc\Service\BarangService;
use PHPUnit\Framework\TestCase;

class BarangControllerTest extends TestCase{
    private BarangRepository $barangRepository;
    private BarangController $barangController;

    private $postData = [
        'id_barang' => 1,
        'nama_barang' => 'Barang Test',
        'jenis_barang' => 'Jenis Test'
    ];
   


    function setUp(): void{

        $this->barangController = new BarangController();
        $this->barangRepository = new BarangRepository(Database::getConnection());

        $this->barangRepository->deleteAll();

        putenv("mode=test");
    }


    function testView(){
        $this->barangController->viewbarang();

        $this->expectOutputRegex('[ID Barang]');
        $this->expectOutputRegex('[Nama Barang]');
        $this->expectOutputRegex('[Jenis Barang]');
        
    }

    function testviewbarang(){

        $barang = new Barang();
        $barang->id_barang = '1';
        $barang->nama_barang = 'matcha';
        $barang->jenis_barang = 'minuman';

        $this->barangRepository->save($barang);

        $this->barangController->viewbarang();

        $this->expectOutputRegex('[matcha]');


    }

}
?>