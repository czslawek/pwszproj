<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
</head>

<body>
<div class="container">
    <div class="row">
        <table class="table table-striped table-hover">
            <thead>
            <th>id</th>
            <th>imie</th>
            <th>nazwisko</th>
            <th>miejscowosc</th>
            <th>kod</th>
            <th>ulica</th>
            <th>nr domu</th>
            <th>mieszkanie</th>
            <th>nip</th>
            <!--<th>regon</th>-->
            <th>nazwa firmy</th>
            </thead>
            <tbody>
            <?php
            require 'db.php';

            $conn = DB::connect();
            $sql = 'SELECT * FROM sczerpak.sprzedajacy';
            //$query = $conn->query($sql);
            //$query->setFetchMode(PDO::FETCH_NUM);

            foreach ($conn->query($sql) as $row) {
                echo '<tr>';
                echo '<td>' . $row['id_sprzedajacy'] . '</td>';
                echo '<td>' . $row['imie'] . '</td>';
                echo '<td>' . $row['nazwisko'] . '</td>';
                echo '<td>' . $row['miejscowosc'] . '</td>';
                echo '<td>' . $row['kod_pocztowy'] . '</td>';
                echo '<td>' . $row['ulica'] . '</td>';
                echo '<td>' . $row['nr_domu'] . '</td>';
                echo '<td>' . $row['nr_mieszkania'] . '</td>';
                echo '<td>' . $row['nip'] . '</td>';
                //echo '<td>' . $row['regon'] . '</td>';
                echo '<td>' . $row['nazwa_firmy'] . '</td>';
                echo '<td> <a href="edit_sprzedawca.php?id_sprzedajacy='.$row['id_sprzedajacy'].'"> <span title="Edit" class="glyphicon glyphicon-edit"></span></a></td>';
                echo '<td> <a href="delete_sprzedawca.php?id_sprzedajacy='.$row['id_sprzedajacy'].'""> <span title="Delete" class="glyphicon glyphicon-remove-sign"></span></a> </td>';
                echo '</tr>';
            }

            DB::disconnect();
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
