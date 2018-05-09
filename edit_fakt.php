<?php
require "db.php";

$conn = DB::connect();

$id = $_GET["id_faktura"];
$sql = "select * from sczerpak.faktura
left join sczerpak.sprzedajacy using(id_sprzedajacy)
left join sczerpak.klient using(id_klient)
left join sczerpak.pozycja_faktury using(id_faktura)
left join sczerpak.towar using(id_towar) 
where id_faktura=:id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);


if($stmt->rowCount() > 0 ) {

    $array = $stmt->fetchAll();
    //var_dump($array);

    print_r($array[0]['id_faktura']);
    $iterator = new IteratorIterator($stmt);

    foreach ($iterator as $row) {
        echo '<td><label>Faktura</label></td><td><input type="text" name="nr_faktura" value=' . $row['nr_faktura'] . ' ></td>';
        echo '<td><label>Towar</label></td><td><input type="text" name="towar" value=' . $row['nazwa_towaru'] . '></td>';
    }
} else {
    echo "Brak rekordów";
}

?>