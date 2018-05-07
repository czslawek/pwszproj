<?php
if (isset($_POST['submit'])) {
    require 'db.php';
    $conn = DB::connect();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("INSERT INTO sczerpak.klient(imie, nazwisko, miejscowosc, kod_pocztowy, ulica, nr_domu, 
            nr_mieszkania, nip, nazwa_firmy) VALUES (:imie, :nazwisko, :miejscowosc, :kod_pocztowy, :ulica, :nr_domu, :nr_mieszkania, :nip, :nazwa_firmy)");

    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $miejscowosc = $_POST['miejscowosc'];
    $kod_pocztowy = $_POST['kod_pocztowy'];
    $ulica = $_POST['ulica'];
    $nr_domu = $_POST['nr_domu'];
    $nr_mieszkania = $_POST['nr_mieszkania'];
    $nip = $_POST['nip'];
    $nazwa_firmy = $_POST['nazwa_firmy'];

    $stmt->bindParam(':imie', $imie);
    $stmt->bindParam(':nazwisko', $nazwisko);
    $stmt->bindParam(':miejscowosc', $miejscowosc);
    $stmt->bindParam(':kod_pocztowy', $kod_pocztowy);
    $stmt->bindParam(':ulica', $ulica);
    $stmt->bindParam(':nr_domu', $nr_domu);
    $stmt->bindParam(':nr_mieszkania', $nr_mieszkania);
    $stmt->bindParam(':nip', $nip);
    $stmt->bindParam(':nazwa_firmy', $nazwa_firmy);


    if ($stmt->execute()) {
        $success_message = "Added Successfully";
    } else {
        $error_message = "Problem in Adding New Record";
    }

    DB::disconnect();
}
?>
<html>
<head>
    <link href="style.css" rel="stylesheet" type="text/css"/>

    <style>
        .tbl-qa {
            border-spacing: 0px;
            border-radius: 4px;
            border: #6ab5b9 1px solid;
        }
    </style>
    <title>Add New Employee</title>
</head>
<body>
<?php if (!empty($success_message)) { ?>
    <div class="success message"><?php echo $success_message; ?></div>
<?php }
if (!empty($error_message)) { ?>
    <div class="error message"><?php echo $error_message; ?></div>
<?php } ?>
<form name="frmUser" method="post" action="">
    <div class="button_link"><a href="klienci.php"> Back to List </a></div>
    <table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tbl-qa">
        <thead>
        <tr>
            <th colspan="2" class="table-header">Add New Employee</th>
        </tr>
        </thead>
        <tbody>
        <tr class="table-row">
            <td><label>Imie</label></td>
            <td><input type="text" name="imie" class="txtField"></td>
            <td><label>Nazwisko</label></td>
            <td><input type="text" name="nazwisko" class="txtField"></td>
            <td><label>Miejscowosc</label></td>
            <td><input type="text" name="miejscowosc" class="txtField"></td>
        </tr>
        <tr class="table-row">
            <td><label>Kod pocztowy</label></td>
            <td><input type="text" name="kod_pocztowy" class="txtField"></td>
            <td><label>Ulica</label></td>
            <td><input type="text" name="ulica" class="txtField"></td>
            <td><label>Nr domu</label></td>
            <td><input type="text" name="nr_domu" class="txtField"></td>
        </tr>
        <tr class="table-row">
            <td><label>Nr mieszkania</label></td>
            <td><input type="text" name="nr_mieszkania" class="txtField"></td>
            <td><label>NIP</label></td>
            <td><input type="text" name="nip" class="txtField"></td>
            <td><label>Nazwa firmy</label></td>
            <td><input type="text" name="nazwa_firmy" class="txtField"></td>
        </tr>

        <tr class="table-row">
            <td colspan="2"><input type="submit" name="submit" value="Submit" class="demo-form-submit"></td>
        </tr>
        </tbody>
    </table>
</form>
</body>
</html>