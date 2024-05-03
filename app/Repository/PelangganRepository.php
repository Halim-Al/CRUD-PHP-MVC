<?php 

namespace Halim\CrudMvc\Repository;

use Halim\CrudMvc\Domain\Pelanggan;

class PelangganRepository{

    private \PDO $connection;

public function __construct(\PDO $connection) {
    $this->connection = $connection;
}

public function save(Pelanggan $pelanggan): Pelanggan
{
    $statement = $this->connection->prepare("INSERT INTO pelanggan (id_pelanggan, nama_pelanggan, alamat, no_hp) VALUES (?, ?, ?, ?)");
    $statement->execute([$pelanggan->id_pelanggan, $pelanggan->nama_pelanggan, $pelanggan->alamat, $pelanggan->no_hp]);
    return $pelanggan;
}

public function getData()
{
    $statement = $this->connection->prepare("SELECT * FROM pelanggan");
    $statement->execute();
    $result = $statement->fetchAll($this->connection::FETCH_ASSOC);
    return $result;

}

public function getDatapage($limit, $offset)
{
    // Buat query dengan menggunakan LIMIT dan OFFSET
    $query = "SELECT * FROM pelanggan LIMIT :limit OFFSET :offset";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':limit', $limit, $this->connection::PARAM_INT);
    $statement->bindParam(':offset', $offset, $this->connection::PARAM_INT);
    $statement->execute();
    
    // Ambil hasil query
    $result = $statement->fetchAll($this->connection::FETCH_ASSOC);
    return $result;
}

public function findById(string $id): ?pelanggan
{
    $statement = $this->connection->prepare("SELECT id_pelanggan, nama_pelanggan, alamat, no_hp FROM pelanggan WHERE id_pelanggan = ?");
    $statement->execute([$id]);

    try {
        if ($row = $statement->fetch()) {
            $pelanggan = new pelanggan();
            $pelanggan->id_pelanggan = $row['id_pelanggan'];
            $pelanggan->nama_pelanggan = $row['nama_pelanggan'];
            $pelanggan->alamat = $row['alamat'];
            $pelanggan->no_hp = $row['no_hp'];
            return $pelanggan;
        } else {
            return null;
        }
    } finally {
        $statement->closeCursor();
    }
}


public function update(Pelanggan $pelanggan): Pelanggan
{
    $statement = $this->connection->prepare("UPDATE pelanggan SET id_pelanggan = ?, nama_pelanggan = ?, alamat = ?, no_hp = ? WHERE id_pelanggan = ?");
    $statement->execute([
        $pelanggan->id_pelanggan, $pelanggan->nama_pelanggan, $pelanggan->alamat, $pelanggan->no_hp, $pelanggan->id_pelanggan
    ]);
    return $pelanggan;
}

public function deleteById(string $id): void
    {
        $statement = $this->connection->prepare("DELETE FROM pelanggan WHERE id_pelanggan = ?");
        $statement->execute([$id]);
    }


    public function deleteAll(): void
{
    $this->connection->exec("DELETE from pelanggan");
}

public function getDatasearch($id_pelanggan = null, $nama_pelanggan = null, $alamat = null, $no_hp = null)
{
    // Membangun array untuk menyimpan kondisi pencarian
    $conditions = array();
    $parameters = array();

    // Menambahkan kondisi pencarian ke dalam array
    // menggunakan named parameter
    if ($id_pelanggan !== null) {
        $conditions[] = "id_pelanggan = :id_pelanggan";
        $parameters[':id_pelanggan'] = $id_pelanggan;
    }
    if ($nama_pelanggan !== null) {
        $conditions[] = "nama_pelanggan LIKE :nama_pelanggan";
        $parameters[':nama_pelanggan'] = '%' . $nama_pelanggan . '%';
    }
    if ($alamat !== null) {
        $conditions[] = "alamat LIKE :alamat";
        $parameters[':alamat'] = '%' . $alamat . '%';
    }
    if ($no_hp !== null) {
        $conditions[] = "no_hp LIKE :no_hp";
        $parameters[':no_hp'] = '%' . $no_hp . '%';
    }

    // Menggabungkan kondisi pencarian menjadi satu string
    $whereClause = implode(" OR ", $conditions);

    // Menyiapkan query dengan kondisi pencarian
    $query = "SELECT * FROM pelanggan";
    if (!empty($conditions)) {
        $query .= " WHERE " . $whereClause;
    }

    // Menyiapkan statement dan mengeksekusi query dengan parameter
    $statement = $this->connection->prepare($query);
    $statement->execute($parameters);

    // Mengambil hasil query
    $result = $statement->fetchAll($this->connection::FETCH_ASSOC);

    return $result;
}


public function getDatapageSearch($limit, $offset, $id_pelanggan = null, $nama_pelanggan = null, $alamat = null, $no_hp = null)
{
    // Inisialisasi parameter query
    $params = array();
    $params['limit'] = (int) $limit; // Mengonversi batas menjadi integer
    $params['offset'] = (int) $offset; // Mengonversi offset menjadi integer
    
    // Buat query dasar
    $query = "SELECT * FROM pelanggan";
    
    // Tambahkan kondisi pencarian jika parameter pencarian diberikan
    if ($id_pelanggan !== null) {
        $conditions[] = "id_pelanggan = :id_pelanggan";
        $params['id_pelanggan'] = intval($id_pelanggan); // Konversi nilai id_barang menjadi integer
    }if ($nama_pelanggan !== null) {
        $conditions[] = "nama_pelanggan LIKE :nama_pelanggan";
        $params['nama_pelanggan'] = '%' . $nama_pelanggan . '%';
    }if ($alamat !== null) {
        $conditions[] = "alamat LIKE :alamat";
        $params['alamat'] = '%' . $alamat . '%';
    }
    if ($no_hp !== null) {
        $conditions[] = "no_hp LIKE :no_hp";
        $params['no_hp'] = '%' . $no_hp . '%';
    }
    
    // Gabungkan kondisi pencarian ke dalam query
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" OR ", $conditions);
    }
    
    // Tambahkan LIMIT dan OFFSET ke dalam query
    $query .= " LIMIT :limit OFFSET :offset";
    
    // Persiapkan dan jalankan statement SQL
    $statement = $this->connection->prepare($query);
    foreach ($params as $key => &$value) {
        $paramType = is_int($value) ? $this->connection::PARAM_INT : $this->connection::PARAM_STR; // Tentukan tipe parameter sesuai dengan tipe data
        $statement->bindParam(':' . $key, $value, $paramType); // Bind parameter dengan tipe yang sesuai
    }
    $statement->execute();
    
    // Ambil hasil query
    $result = $statement->fetchAll($this->connection::FETCH_ASSOC);
    return $result;
    }



}

?>