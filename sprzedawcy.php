<?php include 'include\header.php' ?>
<body>
<?php include 'include\sidenav.php'; ?>

    <div id="page-content-wrapper" class="container">
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

                        $total = $conn->query('SELECT COUNT(*) FROM sczerpak.sprzedajacy')->fetchColumn();
                        $limit = 20;
                        $total_pages = (int) ceil($total / $limit);

                        if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
                        $offset = ($page-1) * $limit;

                        $stmt = $conn->prepare('SELECT * FROM sczerpak.sprzedajacy ORDER BY id_sprzedajacy LIMIT :limit OFFSET :offset');
                        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
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
                    echo '</tbody></table>';

                    $pagLink = "<nav><ul class='pagination'>";

                    for ($i=1; $i <= $total_pages; $i++) {
                        $pagLink .= "<li><a href='sprzedawcy.php?page=".$i."'>".$i."</a></li>";
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


    <script type="text/javascript">
        $(document).ready(function(){
            $('.pagination').pagination({
                items: <?php echo $total;?>,
                itemsOnPage: <?php echo $limit;?>,
                cssStyle: 'light-theme',
                currentPage : <?php echo $page;?>,
                hrefTextPrefix : 'sprzedawcy.php?page='
            });
        });
    </script>
<?php include 'include\footer.php';?>
</body>
