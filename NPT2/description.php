<?php
// Load the XML file
$xml = new DOMDocument;

if (!file_exists('Nimed.xml')) {
    die('Error: Nimed.xml file does not exist.');
}

if (!$xml->load('Nimed.xml')) {
    die('Error loading XML file.');
}

// Get the ID from the query string
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Initialize variables for details
$nimi = $sugu = $emakeelne_nimi = $voorkeelne_nimi = $populaarne = $riik = $gender = '';

if ($id) {
    // Find the "inimene" node with the matching ID
    foreach ($xml->getElementsByTagName('inimene') as $inimene) {
        $nodeId = $inimene->getElementsByTagName('id')->length > 0 ? $inimene->getElementsByTagName('id')->item(0)->textContent : '';
        if ($nodeId == $id) {
            $nimi = $inimene->getElementsByTagName('first_name')->length > 0 ? $inimene->getElementsByTagName('first_name')->item(0)->textContent : '';
            $sugu = $inimene->getElementsByTagName('gender')->length > 0 && $inimene->getElementsByTagName('gender')->item(0)->hasAttribute('nimi') ? $inimene->getElementsByTagName('gender')->item(0)->getAttribute('nimi') : '';
            $emakeelne_nimi = $inimene->getElementsByTagName('emakeelne_nimi')->length > 0 ? $inimene->getElementsByTagName('emakeelne_nimi')->item(0)->textContent : '';
            $voorkeelne_nimi = $inimene->getElementsByTagName('võõrkeelne_nimi')->length > 0 ? $inimene->getElementsByTagName('võõrkeelne_nimi')->item(0)->textContent : '';
            $populaarne = $inimene->getElementsByTagName('populaarne')->length > 0 && $inimene->getElementsByTagName('populaarne')->item(0)->hasAttribute('nimi') ? $inimene->getElementsByTagName('populaarne')->item(0)->getAttribute('nimi') : '';
            $riik = $inimene->getElementsByTagName('riik')->length > 0 && $inimene->getElementsByTagName('riik')->item(0)->hasAttribute('nimi') ? $inimene->getElementsByTagName('riik')->item(0)->getAttribute('nimi') : '';
            $gender = $inimene->getElementsByTagName('gender')->length > 0 && $inimene->getElementsByTagName('gender')->item(0)->hasAttribute('nimi') ? $inimene->getElementsByTagName('gender')->item(0)->getAttribute('nimi') : '';
            break;
        }
    }
}

if (!$nimi) {
    echo "<p>No details found for ID $id.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailid <?php echo htmlspecialchars($nimi); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        ul {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            list-style-type: none;
            margin: 0 auto;
            width: 80%;
            max-width: 600px;
        }
        li {
            font-size: 1.1em;
            margin: 10px 0;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        li:last-child {
            border-bottom: none;
        }
        strong {
            color: #555;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            width: 120px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h1>info <?php echo htmlspecialchars($nimi); ?> kohta</h1>
<ul>
    <li><strong>Nimi:</strong> <?php echo htmlspecialchars($nimi); ?></li>
    <li><strong>Sugu:</strong> <?php echo htmlspecialchars($sugu); ?></li>
    <li><strong>emakeelne nimi:</strong> <?php echo htmlspecialchars($emakeelne_nimi); ?></li>
    <li><strong>võõrkeelne nimi:</strong> <?php echo htmlspecialchars($voorkeelne_nimi); ?></li>
    <li><strong>populaarne:</strong> <?php echo htmlspecialchars($populaarne); ?></li>
    <li><strong>riik:</strong> <?php echo htmlspecialchars($riik); ?></li>

</ul>
<a href="javascript:window.close();">sule</a>
</body>
</html>