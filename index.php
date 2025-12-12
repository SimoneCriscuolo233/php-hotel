<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>PHP Hotel</title>
</head>
<body class="p-4">

<?php

$hotels = [
    [
        'name' => 'Hotel Belvedere',
        'description' => 'Hotel Belvedere Descrizione',
        'parking' => true,
        'vote' => 4,
        'distance_to_center' => 10.4
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel Futuro Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Hotel Rivamare Descrizione',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel Bellavista Descrizione',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel Milano Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50
    ],
];


$filterParking = ($_GET['parking'] ?? '') === '1';
$filterVote = $_GET['vote'] ?? '';
if ($filterVote === '') {
    $filterVote = null;
} else {
    $filterVote = $filterVote + 0;
}

$filteredHotels = [];
foreach ($hotels as $hotel) {
    $includeHotel = true;

    if ($filterParking === true) {
        if ($hotel['parking'] === false) {
            $includeHotel = false;
        }
    }

    if ($filterVote !== null) {
        if ($hotel['vote'] < $filterVote) {
            $includeHotel = false;
        }
    }

    if ($includeHotel) {
        $filteredHotels[] = $hotel;
    }
}

?>

<div class="container">

    <form method="GET" class="mb-4 row g-3 align-items-end">
        <div class="col-auto form-check">
            <input type="checkbox" class="form-check-input" id="parking" name="parking" value="1" <?php echo $filterParking ? 'checked' : ''; ?>>
            <label for="parking" class="form-check-label">Solo hotel con parcheggio</label>
        </div>

        <div class="col-auto">
            <label for="vote" class="form-label">Voto minimo</label>
            <input type="number" min="1" max="5" class="form-control" id="vote" name="vote" value="<?php echo $filterVote !== null ? $filterVote : ''; ?>">
        </div>

        <div class="col-auto">
            <button class="btn btn-primary">Filtra</button>
            <a href="index.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <?php 
                foreach ($hotels[0] as $key => $value) {
                    echo "<th>" . $key . "</th>";
                }
                ?>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($filteredHotels as $hotel) { 
                echo "<tr>";
                foreach ($hotel as $key => $value) { 
                    if ($key === 'parking') {
                        $value = $value ? 'Sì' : 'No';
                    }
                    echo "<td> $value </td>";
                } 
                echo "</tr>";
            }?> 
        </tbody>
    </table>

    <?php if (count($filteredHotels) < 1) { ?>
        <div class="alert alert-warning">Nessun hotel trovato con i filtri selezionati.</div>
    <?php } ?>

</div>

</body>
</html>
