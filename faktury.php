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
    <link rel="stylesheet" href="css/simple-sidebar.css">
    <link type="text/css" rel="stylesheet" href="css/simplePagination.css"/>
</head>


<body>
<div class="sidenav">
    <a href="faktury.php">OOO</a>
    <a href="#">Dashboard</a>
    <a href="#">11111111</a>
    <a href="#">2222222222</a>
    <a href="#">3333333333</a>
</div>
<div id="page-content-wrapp" class="container">
    <div class="row">
        <table class="table table-striped table-hover">
            <thead></thead>
            <tbody>
            <?php
            require 'db.php';


            try {
                $conn = DB::connect();

                $total = $conn->query('SELECT COUNT(*) FROM sczerpak.sprzedajacy')->fetchColumn();
                $limit = 20;
                $total_pages = (int)ceil($total / $limit);

                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                } else {
                    $page = 1;
                };
                $offset = ($page - 1) * $limit;

                $stmt = $conn->prepare('SELECT * FROM sczerpak.faktura 
                          JOIN  sczerpak.sprzedajacy USING(id_sprzedajacy)
                          JOIN sczerpak.klient USING(id_klient) ORDER BY id_faktura LIMIT :limit OFFSET :offset');

                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $iterator = new IteratorIterator($stmt);
                    foreach ($iterator as $row) {
                        echo '<tr>';
                        echo '<td>' . $row['id_faktura'] . '</td>';
                        echo '<td>' . $row['nazwa_firmy'] . '</td>';
                        echo '<td>' . $row['data_wystawienia'] . '</td>';
                        echo '<td> <a href="edit_fakt.php?id_faktura=' . $row['id_faktura'] . '"> <span title="Edit" class="glyphicon glyphicon-edit"></span></a></td>';
                        echo '<td> <a href="delete_fakt.php?id_faktura=' . $row['id_faktura'] . '""> <span title="Delete" class="glyphicon glyphicon-remove-sign"></span></a> </td>';
                        echo '</tr>';
                    }

                } else {
                    echo '<p>No results could be displayed.</p>';
                }

            } catch (Exception $e) {
                echo '<p>', $e->getMessage(), '</p>';
            }
            echo '</tbody></table>';

            $pagLink = "<nav><ul class='pagination'>";

            for ($i = 1; $i <= $total_pages; $i++) {
                $pagLink .= "<li><a href='faktury.php?page=" . $i . "'>" . $i . "</a></li>";
            };
            echo $pagLink . "</ul></nav>";
            DB::disconnect();

            ?>

    </div>
</div>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="vendor/jquery/jquery.simplePagination.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.pagination').pagination({
            items: <?php echo $total;?>,
            itemsOnPage: <?php echo $limit;?>,
            cssStyle: 'light-theme',
            currentPage: <?php echo $page;?>,
            hrefTextPrefix: 'faktury.php?page='
        });
    });
</script>

