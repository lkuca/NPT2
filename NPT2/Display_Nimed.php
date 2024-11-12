<?php
// Create a new DOMDocument for XML
$xml = new DOMDocument;

// Load the XML file
if (!file_exists('Nimed.xml')) {
    die('Error: Nimed.xml file does not exist.');
}

if (!$xml->load('Nimed.xml')) {
    die('Error loading XML file.');
}

// Create a new DOMDocument for XSLT
$xslt = new DOMDocument;

// Load the XSLT file
if (!file_exists('NimedLisa.xslt')) {
    die('Error: NimedLisa.xslt file does not exist.'); // Updated to xslt
}

if (!$xslt->load('NimedLisa.xslt')) {
    die('Error loading XSLT file.'); // Updated to xslt
}

// Create a new XSLTProcessor
$proc = new XSLTProcessor;

// Import the XSLT stylesheet
$proc->importStyleSheet($xslt);

// Transform the XML to HTML
$htmlOutput = $proc->transformToXML($xml);

// Check if the transformation was successful
if ($htmlOutput === false) {
    die('Error during XSLT transformation.');
}

// Function to find names starting with the given two letters
function findNamesByLetters($xml, $letters) {
    // Prepare result array
    $result = [];

    // Loop through each 'inimene' element
    foreach ($xml->getElementsByTagName('inimene') as $inimene) {
        // Get the first name from the XML data
        $firstName = $inimene->getElementsByTagName('first_name')->item(0)->textContent;

        // Check if the first name starts with the given letters (case-insensitive)
        if (stripos($firstName, $letters) === 0) {
            // If it matches, add the name to the result array
            $result[] = $firstName;
        }
    }

    // Return the result (if any names were found)
    return $result;
}

// Process the form submission for searching names
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $letters = trim($_POST['letters']);
    if (!empty($letters)) {
        // Find names that start with the given letters
        $names = findNamesByLetters($xml, $letters);

        // Output the results
        if (!empty($names)) {
            echo "<h3>Found names starting with '$letters':</h3>";
            echo "<ul>";
            foreach ($names as $name) {
                echo "<li>$name</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No names found starting with '$letters'.</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nimede pakkumise teenus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #9acd32;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 8px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Nimede pakkumise teenus</h2>

<!-- Search Form -->
<form method="POST">
    <label for="letters">Enter one letter to search names:</label>
    <input type="text" id="letters" name="letters" maxlength="2" required>
    <input type="submit" name="search" value="Search">
</form>

<?php
// Output the transformed HTML (table)
echo $htmlOutput;
?>

</body>
</html>