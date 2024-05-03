<?php 

namespace Halim\CrudMvc\Controller;

use Halim\CrudMvc\App\View;
use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Domain\Pelanggan;
use Halim\CrudMvc\Exception\ValidationException;
use Halim\CrudMvc\Model\PelangganRequest;
use Halim\CrudMvc\Repository\PelangganRepository;
use Halim\CrudMvc\Service\PelangganService;

class PelangganController{

    private PelangganService $pelangganService;

    private PelangganRepository $pelangganRepository;
    private $connection;

    private $query;

    private $page;

    function __construct(){
        $connection = Database::getConnection();
        $this->pelangganRepository = new PelangganRepository($connection);
        $this->pelangganService = new PelangganService($this->pelangganRepository);
        $this->connection = $connection;
        $this->page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->query = isset($_GET['query']) ? $_GET['query']: "asdsa" ;
      
    }

    public function index(){
        if(isset($_GET['query'])){
            $request = new PelangganRequest();
            $request->id_pelanggan = $_GET['query'];
            $request->nama_pelanggan = $_GET['query'];
            $request->alamat = $_GET['query'];
            $request->no_hp = $_GET['query'];

           
          
            $this->getsearch($this->page, $request);
        }
        else{
            $this->showPage($this->page); // Mengirimkan nilai page sebagai argumen
        }
       
    }


    
    public function getsearch($page, PelangganRequest $request){
        // Jumlah item per halaman
    
     $limit = 5;

     $dataquery = [
         "query_id" => $request->id_pelanggan,
         "query_nama" => $request->nama_pelanggan,
         "query_jenis" => $request->alamat,
     ];

     
    

     // Hitung offset berdasarkan halaman
     $start = ($page - 1) * $limit;

      // Ambil data dari database
        
         
     $itemsperpage = $this->pelangganRepository->getDatapageSearch($limit, $start, $request->id_pelanggan, $request->nama_pelanggan, $request->alamat, $request->no_hp);
     
        
         
     
     $totalsearch =  $this->pelangganService->searchbarang($request);
     
     $totalcount = count($totalsearch);

     

     $data = [];
     foreach($itemsperpage as $pelanggan){  
         $data[] = array(
             'id' => $pelanggan['id_pelanggan'],
             'nama' => $pelanggan['nama_pelanggan'],
             'alamat' => $pelanggan['alamat'],
             'no_hp' => $pelanggan['no_hp']
         );
     }

     View::render('Navlink/Searchpelanggan', [
         "title" => "Data Barang",
         'pelangganData' => $data,
         'totalItem' => $totalcount,
         'limit' => $limit
       

     ]);
         
             
         
     }
    public function showPage($page){
        // Jumlah item per halaman
        $limit = 5;

        // Hitung offset berdasarkan halaman
        $start = ($page - 1) * $limit;

         // Ambil data dari database
         $itemsperpage = $this->pelangganRepository->getDatapage($limit, $start);

         $totalitem = $this->pelangganRepository->getData();
         $totalcount = count($totalitem);



         $data = [];
         foreach($itemsperpage as $pelanggan){  
             $data[] = array(
                 'id' => $pelanggan['id_pelanggan'],
                 'nama' => $pelanggan['nama_pelanggan'],
                 'alamat' => $pelanggan['alamat'],
                 'no_hp' => $pelanggan['no_hp']
             );
 
           
         }
        
         View::render('Navlink/Datapelanggan',[
             'title' => 'Data Pelanggan',
             'pelangganData' => $data,
             'totalItem' => $totalcount,
            'limit' => $limit
          
           
 
         ]);
        
    }


    public function viewpelanggan(){
        
        $model =  $this->pelangganRepository->getData();
 
         
 
         $data = [];
         foreach($model as $pelanggan){  
             $data[] = array(
                 'id' => $pelanggan['id_pelanggan'],
                 'nama' => $pelanggan['nama_pelanggan'],
                 'alamat' => $pelanggan['alamat'],
                 'no_hp' => $pelanggan['no_hp']
             );
 
           
         }
        
         View::render('Navlink/Datapelanggan',[
             'title' => 'Data Pelanggan',
             'pelangganData' => $data
           
 
         ]);
     }


     
    public function postpelanggan(){
        $request = new PelangganRequest();
        $request->id_pelanggan = $_POST['id_pelanggan'];
        $request->nama_pelanggan = $_POST['nama_pelanggan'];
        $request->alamat = $_POST['alamat'];
        $request->no_hp = $_POST['no_hp'];

        try{
            $this->pelangganService->addPelanggan($request);
          

        }catch (ValidationException $exception){
              
       $model =  $this->pelangganRepository->getData();

        

       $data = [];
       foreach($model as $pelanggan){  
           $data[] = array(
               'id' => $pelanggan['id_pelanggan'],
               'nama' => $pelanggan['nama_pelanggan'],
               'alamat' => $pelanggan['alamat'],
               'no_hp' => $pelanggan['no_hp']
           );

         
       }
            View::render('Navlink/Datapelanggan', [
                "title" => "Data Pelanggan",
                'pelangganData' => $data,
                'error' => $exception->getMessage()
            ]);
        }  
        }

        public function postupdate(){
            $request = new PelangganRequest();
            $request->id_pelanggan = $_POST['id_pelanggan'];
            $request->nama_pelanggan = $_POST['nama_pelanggan'];
            $request->alamat = $_POST['alamat'];
            $request->no_hp = $_POST['no_hp'];

            try{

                $this->pelangganService->updatepelanggan($request);
                
            }
            catch(ValidationException $exception){
              
                View::render('Navlink/edit/editpelanggan', [
                    'error' => $exception->getMessage()

                ]);

            }


        }

        public function deletePelanggan(){

            $id_pelanggan = $_GET['id'];
            
            $this->pelangganService->deletePelanggan($id_pelanggan);

            
        
    }

    public function editview(){

        if(isset($_GET['id'])){
            $id_pelanggan = $_GET['id'];

            $data_pelanggan = $this->pelangganRepository->findById($id_pelanggan);


            
           
        }

        View::render('Navlink/edit/editpelanggan', [
            'title' => 'Edit Pelanggan',
            'id' => $data_pelanggan->id_pelanggan,
            'nama' => $data_pelanggan->nama_pelanggan,
            'alamat' => $data_pelanggan->alamat,
            'no_hp' => $data_pelanggan->no_hp
          
             // Kirim data barang ke view
        ]);
    }


        
}


?>