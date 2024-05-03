<?php 

namespace Halim\CrudMvc\Controller;

use Halim\CrudMvc\App\View;
use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Domain\Barang;
use Halim\CrudMvc\Exception\ValidationException;
use Halim\CrudMvc\Model\BarangRequest;
use Halim\CrudMvc\Repository\BarangRepository;
use Halim\CrudMvc\Service\BarangService;
use Halim\CrudMvc\Service\UserService;

class BarangController{

    private BarangService $barangService;

    private BarangRepository $barangRepository;
    private $connection;

    private $query;

   
    private $page;

    function __construct(){
        $connection = Database::getConnection();
        $this->barangRepository = new BarangRepository($connection);
        $this->barangService = new BarangService($this->barangRepository);
        $this->connection = $connection;
        $this->page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->query = isset($_GET['query']) ? $_GET['query']: "asdsa" ;
        $barang = new Barang();
    }

   
    public function index(){
        
        if(isset($_GET['query'])){
            $request = new BarangRequest();
            $request->id_barang = $_GET['query'];
            $request->nama_barang = $_GET['query'];
            $request->jenis_barang = $_GET['query'];

           
          
            $this->getsearch($this->page, $request);
        }
        else{
            $this->showPage($this->page); // Mengirimkan nilai page sebagai argumen
        }
      
       
    }
    public function showPage($page){
       
        // Jumlah item per halaman
       
        $limit = 5;

        // Hitung offset berdasarkan halaman
        $start = ($page - 1) * $limit;

         // Ambil data dari database
         $itemsperpage = $this->barangRepository->getDatapage($limit, $start);

         $totalitem = $this->barangRepository->getData();
         $totalcount = count($totalitem);
        

         $data = [];
        foreach($itemsperpage as $barang){  
            $data[] = array(
                'id' => $barang['id_barang'],
                'nama' => $barang['nama_barang'],
                'jenis' => $barang['jenis_barang']
            );

          
        }
        
       
        View::render('Navlink/Databarang',[
            'title' => 'Data Barang',
            'barangData' => $data,
            'totalItem' => $totalcount,
            'limit' => $limit
          

        ]);
        
    }


    public function viewbarang(){
        
       $totalitem =  $this->barangRepository->getData();

        

        $data = [];
        foreach($totalitem as $barang){  
            $data[] = array(
                'id' => $barang['id_barang'],
                'nama' => $barang['nama_barang'],
                'jenis' => $barang['jenis_barang']
            );

          
        }
        
        View::render('Navlink/Databarang',[
            'title' => 'Data Barang',
            'barangData' => $data
          

        ]);
    }

   



    public function postbarang(){
        $request = new BarangRequest();
        $request->id_barang = $_POST['id_barang'];
        $request->nama_barang = $_POST['nama_barang'];
        $request->jenis_barang = $_POST['jenis_barang'];

        try{
            $this->barangService->addbarang($request);
          

        }catch (ValidationException $exception){
              
       $model =  $this->barangRepository->getData();

        

       $data = [];
       foreach($model as $barang){  
           $data[] = array(
               'id' => $barang['id_barang'],
               'nama' => $barang['nama_barang'],
               'jenis' => $barang['jenis_barang']
           );

         
       }
            View::render('Navlink/Databarang', [
                "title" => "Data Barang",
                'barangData' => $data,
                'error' => $exception->getMessage()
            ]);
        }  
        }

        public function postupdate(){
            $request = new BarangRequest();
            $request->id_barang = $_POST['id_barang'];
            $request->nama_barang = $_POST['nama_barang'];
            $request->jenis_barang = $_POST['jenis_barang'];

            try{

                $this->barangService->updatebarang($request);
                
            }
            catch(ValidationException $exception){
              
                View::render('Navlink/edit/editbarang', [
                    'error' => $exception->getMessage()

                ]);

            }


        }

        public function deletebarang(){

                $id_barang = $_GET['id'];
                
                    $this->barangService->deleteBarang($id_barang);

                
            
        }

        public function editview(){

            if(isset($_GET['id'])){
                $id_barang = $_GET['id'];

                $data_barang = $this->barangRepository->findById($id_barang);


                
               
            }

            View::render('Navlink/edit/editbarang', [
                'title' => 'Edit Barang',
                'id' => $data_barang->id_barang,
                'nama' => $data_barang->nama_barang,
                'jenis' => $data_barang->jenis_barang
              
                 // Kirim data barang ke view
            ]);
        }

        public function getsearch($page, BarangRequest $request){
           // Jumlah item per halaman
       
        $limit = 5;

        $dataquery = [
            "query_id" => $request->id_barang,
            "query_nama" => $request->nama_barang,
            "query_jenis" => $request->jenis_barang,
        ];

        
       

        // Hitung offset berdasarkan halaman
        $start = ($page - 1) * $limit;

         // Ambil data dari database
           
            
        $itemsperpage = $this->barangRepository->getDatapageSearch($limit, $start, $request->id_barang, $request->nama_barang, $request->jenis_barang);
        
           
            
        
        $totalsearch =  $this->barangService->searchbarang($request);
        
        $totalcount = count($totalsearch);

        

        $data = [];
        foreach($itemsperpage as $barang){  
            $data[] = array(
                'id' => $barang['id_barang'],
                'nama' => $barang['nama_barang'],
                'jenis' => $barang['jenis_barang']
            );
        }

        View::render('Navlink/Searchbarang', [
            "title" => "Data Barang",
            'barangData' => $data,
            'totalItem' => $totalcount,
            'limit' => $limit
          

        ]);
            
                
            
        }

    }

    
    

?>