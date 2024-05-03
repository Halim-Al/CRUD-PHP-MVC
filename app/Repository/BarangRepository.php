<?php 

namespace Halim\CrudMvc\Repository;

use Halim\CrudMvc\Domain\Barang;


class BarangRepository{
    
private \PDO $connection;

public function __construct(\PDO $connection) {
    $this->connection = $connection;
}

public function save(Barang $barang): Barang
{
    $statement = $this->connection->prepare("INSERT INTO barang (id_barang, nama_barang, jenis_barang) VALUES (?, ?, ?)");
    $statement->execute([$barang->id_barang, $barang->nama_barang, $barang->jenis_barang]);
    return $barang;
}

public function getData()
{
    $statement = $this->connection->prepare("SELECT * FROM barang");
    $statement->execute();
    $result = $statement->fetchAll($this->connection::FETCH_ASSOC);
    return $result;

}


public function getDatapage($limit, $offset)
{
    // Buat query dengan menggunakan LIMIT dan OFFSET
    $query = "SELECT * FROM barang LIMIT :limit OFFSET :offset";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':limit', $limit, $this->connection::PARAM_INT);
    $statement->bindParam(':offset', $offset, $this->connection::PARAM_INT);
    $statement->execute();
    
    // Ambil hasil query
    $result = $statement->fetchAll($this->connection::FETCH_ASSOC);
    return $result;
}


public function getDatapageSearch($limit, $offset, $id_barang = null, $nama_barang = null, $jenis_barang = null)
{
    // Inisialisasi parameter query
    $params = array();
    $params['limit'] = (int) $limit; // Mengonversi batas menjadi integer
    $params['offset'] = (int) $offset; // Mengonversi offset menjadi integer
    
    // Buat query dasar
    $query = "SELECT * FROM barang";
    
    // Tambahkan kondisi pencarian jika parameter pencarian diberikan
    if ($id_barang !== null) {
        $conditions[] = "id_barang = :id_barang";
        $params['id_barang'] = intval($id_barang); // Konversi nilai id_barang menjadi integer
    }if ($nama_barang !== null) {
        $conditions[] = "nama_barang LIKE :nama_barang";
        $params['nama_barang'] = '%' . $nama_barang . '%';
    }if ($jenis_barang !== null) {
        $conditions[] = "jenis_barang LIKE :jenis_barang";
        $params['jenis_barang'] = '%' . $jenis_barang . '%';
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
    
    
    public function getDatasearch($id_barang = null, $nama_barang = null, $jenis_barang = null)
    {
        // Membangun array untuk menyimpan kondisi pencarian
        $conditions = array();
        $parameters = array();
    
        // Menambahkan kondisi pencarian ke dalam array
        // menggunakan named parameter
        if ($id_barang !== null) {
            $conditions[] = "id_barang = :id_barang";
            $parameters[':id_barang'] = $id_barang;
        }
        if ($nama_barang !== null) {
            $conditions[] = "nama_barang LIKE :nama_barang";
            $parameters[':nama_barang'] = '%' . $nama_barang . '%';
        }
        if ($jenis_barang !== null) {
            $conditions[] = "jenis_barang LIKE :jenis_barang";
            $parameters[':jenis_barang'] = '%' . $jenis_barang . '%';
        }
    
        // Menggabungkan kondisi pencarian menjadi satu string
        $whereClause = implode(" OR ", $conditions);
    
        // Menyiapkan query dengan kondisi pencarian
        $query = "SELECT * FROM barang";
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
public function findById(string $id): ?Barang
{
    $statement = $this->connection->prepare("SELECT id_barang, nama_barang, jenis_barang FROM barang WHERE id_barang = ?");
    $statement->execute([$id]);

    try {
        if ($row = $statement->fetch()) {
            $barang = new Barang();
            $barang->id_barang = $row['id_barang'];
            $barang->nama_barang = $row['nama_barang'];
            $barang->jenis_barang = $row['jenis_barang'];
            return $barang;
        } else {
            return null;
        }
    } finally {
        $statement->closeCursor();
    }
}

public function update(Barang $Barang): Barang
{
    $statement = $this->connection->prepare("UPDATE barang SET id_barang = ?, nama_barang = ?, jenis_barang = ? WHERE id_barang = ?");
    $statement->execute([
        $Barang->id_barang, $Barang->nama_barang, $Barang->jenis_barang, $Barang->id_barang
    ]);
    return $Barang;
}


public function deleteById(string $id): void
    {
        $statement = $this->connection->prepare("DELETE FROM barang WHERE id_barang = ?");
        $statement->execute([$id]);
    }

public function deleteAll(): void
{
    $this->connection->exec("DELETE from barang");
}

}

?>