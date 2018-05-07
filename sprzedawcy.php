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
</head>

<body>
<div id="wrapper" class="toggled">
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">OOO</li>
            <li><a href="#">Dashboard</a></li>
            <li>Sprzedajacy</li>
            <li>Faktury</li>
            <li>Towary</li>
            <li>Kontakt</li>
        </ul>
    </div>

    <div id="page-content-wrapper" class="container">

        <div class="container-fluid">
            <button type="button" class="btn btn-secondary btn-sm" id="menu-toggle">Small button</button>

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

                    try {
                        $conn = DB::connect();
                        $sql = 'SELECT * FROM sczerpak.sprzedajacy';
                        // Find out how many items are in the table
                        $total = $conn->query('SELECT COUNT(*) FROM sczerpak.sprzedajacy')->fetchColumn();

                        // How many items to list per page
                        $limit = 20;

                        // How many pages will there be
                        $pages = ceil($total / $limit);

                        // What page are we currently on?
                        $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                            'options' => array(
                                'default' => 1,
                                'min_range' => 1,
                            ),
                        )));

                        // Calculate the offset for the query
                        $offset = ($page - 1) * $limit;

                        // Some information to display to the user
                        $start = $offset + 1;
                        $end = min(($offset + $limit), $total);

                        // The "back" link
                        $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

                        // The "forward" link
                        $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

                        // Prepare the paged query
                        $stmt = $conn->prepare('SELECT * FROM sczerpak.sprzedajacy ORDER BY id_sprzedajacy LIMIT :limit OFFSET :offset');

                        // Bind the query params
                        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                        $stmt->execute();


                        //$query = $conn->query($sql);
                        //$query->setFetchMode(PDO::FETCH_NUM);
                        if ($stmt->rowCount() > 0) {
                            // Define how we want to fetch the results
                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                            $iterator = new IteratorIterator($stmt);

                            foreach ($iterator as $row) {
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
                                echo '<td> <a href="edit_sprzedawca.php?id_sprzedajacy=' . $row['id_sprzedajacy'] . '"> <span title="Edit" class="glyphicon glyphicon-edit"></span></a></td>';
                                echo '<td> <a href="delete_sprzedawca.php?id_sprzedajacy=' . $row['id_sprzedajacy'] . '""> <span title="Delete" class="glyphicon glyphicon-remove-sign"></span></a> </td>';
                                echo '</tr>';
                            }

                        } else {
                            echo '<p>No results could be displayed.</p>';
                        }

                    } catch (Exception $e) {
                        echo '<p>', $e->getMessage(), '</p>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                    DB::disconnect();
                    // Display the paging information
                    echo '<div class="pagination"><p>', $prevlink, ' Page ', $page, ' / ', $pages, ' of ', $total, ' results ', $nextlink, ' </p></div>';
                    ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>
