<?php
// Load the XML file
$xml = new DOMDocument;

if (!file_exists('Nimed.xml')) {
    die('Error: Nimed.xml file does not exist.');
}

if (!$xml->load('Nimed.xml')) {
    die('Error loading XML file.');
}
if (isset($_POST['submit'])) {
    // Capture form data
    $populaarne_nimi = $_POST['populaarne_nimi'];
    $riik_nimi = $_POST['riik_nimi'];
    $gender_nimi = $_POST['gender_nimi'];
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $emakeelne_nimi = $_POST['emakeelne_nimi'];
    $voorkeelne_nimi = $_POST['voorkeelne_nimi'];

    // Create the new data structure
    $newData = [
        "populaarne" => [
            "nimi" => $populaarne_nimi,
            "riik" => [
                "nimi" => $riik_nimi,
                "gender" => [
                    "nimi" => $gender_nimi,
                    "id" => $id,
                    "first_name" => $first_name,
                    "emakeelne_nimi" => $emakeelne_nimi,
                    "võõrkeelne_nimi" => $voorkeelne_nimi
                ]
            ]
        ]
    ];

    // Define the path to the JSON file
    $jsonFile = 'jsonifail.json';

    // Check if the file exists
    if (file_exists($jsonFile)) {
        // Read the existing data from the JSON file
        $jsonData = file_get_contents($jsonFile);

        // Decode the JSON data into an associative array
        $data = json_decode($jsonData, true);

        // Append the new data to the 'inimene' array
        $data['Nimed']['inimene'][] = $newData;

        // Encode the updated data back into JSON format
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        // Save the updated data back into the JSON file
        file_put_contents($jsonFile, $jsonData);

        echo "Data added successfully!";
    } else {
        // If the file does not exist, create a new file and add the data
        $data = [
            "Nimed" => [
                "inimene" => [$newData]
            ]
        ];

        // Encode the data into JSON format
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        // Save the data to the JSON file
        file_put_contents($jsonFile, $jsonData);

        echo "JSON file created and data added!";
    }
}

// Start output buffering
ob_start();
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nimede pakkumise teenus Table</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #32373c; /* Dark background for a moody effect */
                color: #e0e0e0; /* Light text color for contrast */
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
            }

            h1 {
                color: #d3e3d7; /* Green text */
                text-shadow: 2px 2px 10px rgba(0, 255, 0, 0.5);
                font-size: 2em;
                margin-top: 20px;
            }

            p {
                color: #999999;
                font-size: 1.1em;
            }

            table {
                width: 80%;
                margin-top: 20px;
                border-collapse: collapse;
                background-color: #32373c; /* Dark table background */
                border-radius: 8px;
                overflow: hidden;
            }

            th, td {
                padding: 12px;
                text-align: left;
                border: 1px solid #333;
            }

            th {
                background-color: #222; /* Dark background for headers */
                color: #d3e3d7; /* Green header text */
                text-shadow: 1px 1px 6px rgba(0, 255, 0, 0.3);
            }

            td {
                background-color: #333;
                color: #e0e0e0;
                border-top: 1px solid #444; /* Lighter border color */
            }

            tr:nth-child(odd) {
                background-color: #2a2a2a;
            }

            tr:nth-child(even) {
                background-color: #1e1e1e;
            }

            tr:hover {
                background-color: #3e3e3e; /* Slightly lighter on hover */
            }

            .sortable {
                cursor: pointer;
                color: #d3e3d7; /* Green for clickable columns */
            }

            .sortable:hover {
                text-decoration: underline;
            }

            input[type="text"], input[type="number"], button {
                background-color: #1c1c1c;
                border: 1px solid #444;
                color: #e0e0e0;
                padding: 10px;
                font-size: 1em;
                margin-top: 10px;
                border-radius: 5px;
                width: 100%;
                max-width: 400px;
            }

            button {
                background-color: #d3e3d7; /* Green button */
                color: #32373c;
                font-weight: bold;
                border: none;
                cursor: pointer;
            }

            button:hover {
                background-color: #d3e3d7; /* Darker green on hover */
            }

            .search-bar {
                margin-bottom: 20px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            #searchInput {
                background-color: #1c1c1c;
                border: 1px solid #444;
                color: #e0e0e0;
                padding: 10px;
                font-size: 1.1em;
                width: 50%;
                border-radius: 5px;
            }

            #searchInput::placeholder {
                color: #888; /* Light placeholder text */
            }

            a {
                color: #d3e3d7;
                text-decoration: none;
            }

            a:hover {
                text-decoration: underline;
            }

            footer {
                margin-top: 40px;
                padding: 20px;
                background-color: #32373c;
                color: #888;
                text-align: center;
            }

            .error-message {
                color: #ff4444; /* Red color for errors */
                font-weight: bold;
            }
        </style>
        <script>
            function sortTable(columnIndex) {
                const table = document.getElementById("searchResults");
                const rows = Array.from(table.rows).slice(1); // Exclude header row
                const order = table.dataset.order === "asc" ? "desc" : "asc";
                table.dataset.order = order;

                rows.sort((a, b) => {
                    const cellA = a.cells[columnIndex].textContent.trim();
                    const cellB = b.cells[columnIndex].textContent.trim();
                    return order === "asc"
                        ? cellA.localeCompare(cellB)
                        : cellB.localeCompare(cellA);
                });

                rows.forEach(row => table.appendChild(row)); // Reorder rows
            }

            function searchTable() {
                // Get the input value (one letter)
                var input = document.getElementById("searchInput").value.toLowerCase();

                // Get all the rows from the table
                var rows = document.getElementById("searchResults").getElementsByTagName("tr");

                // Loop through all rows
                for (var i = 0; i < rows.length; i++) {
                    // Get the cell that contains the first name (it is in the 2nd column, index 1)
                    var firstNameCell = rows[i].getElementsByTagName("td")[1];

                    // If the first_name cell exists
                    if (firstNameCell) {
                        var firstNameText = firstNameCell.textContent || firstNameCell.innerText;

                        // Check if the first letter of the first_name matches the input (case-insensitive)
                        if (firstNameText.toLowerCase().startsWith(input)) {
                            rows[i].style.display = ""; // Show matching rows
                        } else {
                            rows[i].style.display = "none"; // Hide non-matching rows
                        }
                    }
                }
            }
        </script>
    </head>
    <body>
    <h1>Nimede pakkumise teenus</h1>
    <td>nimesid saate sortida, klõpsates: populaarne, riik ja sugu. Kui soovite nimede kohta rohkem teavet näha, klõpsake neil</td>
    <br>
    <input type="text" id="searchInput" placeholder="Search name" onkeyup="searchTable()" maxlength="1"/>
    <table id="searchResults" data-order="asc">
        <thead>
        <tr>
            <th>id</th>
            <th>nimi</th>
            <th>emakeelne nimi</th>
            <th>võõrkeelne nimi</th>
            <th class="sortable" onclick="sortTable(4)">populaarne</th>
            <th class="sortable" onclick="sortTable(5)">riik</th>
            <th class="sortable" onclick="sortTable(6)">sugu</th>
        </tr>
        </thead>

        <tbody>
        <?php
        // Iterate through each "inimene" node
        foreach ($xml->getElementsByTagName('inimene') as $inimene) {
            // Extract data using ternary operators
            $id = $inimene->getElementsByTagName('id')->length > 0 ? $inimene->getElementsByTagName('id')->item(0)->textContent : '';
            $nimi = $inimene->getElementsByTagName('first_name')->length > 0 ? $inimene->getElementsByTagName('first_name')->item(0)->textContent : '';
            $emakeelne_nimi = $inimene->getElementsByTagName('emakeelne_nimi')->length > 0 ? $inimene->getElementsByTagName('emakeelne_nimi')->item(0)->textContent : '';
            $voorkeelne_nimi = $inimene->getElementsByTagName('võõrkeelne_nimi')->length > 0 ? $inimene->getElementsByTagName('võõrkeelne_nimi')->item(0)->textContent : '';
            $populaarne = $inimene->getElementsByTagName('populaarne')->length > 0 && $inimene->getElementsByTagName('populaarne')->item(0)->hasAttribute('nimi') ? $inimene->getElementsByTagName('populaarne')->item(0)->getAttribute('nimi') : '';
            $riik = $inimene->getElementsByTagName('riik')->length > 0 && $inimene->getElementsByTagName('riik')->item(0)->hasAttribute('nimi') ? $inimene->getElementsByTagName('riik')->item(0)->getAttribute('nimi') : '';
            $gender = $inimene->getElementsByTagName('gender')->length > 0 && $inimene->getElementsByTagName('gender')->item(0)->hasAttribute('nimi') ? $inimene->getElementsByTagName('gender')->item(0)->getAttribute('nimi') : '';

            // Output each row
            echo "<tr>
    <td>$id</td>
    <td><a href='description.php?id=$id' target='_blank'>$nimi</a></td>
    <td>$emakeelne_nimi</td>
    <td>$voorkeelne_nimi</td>
    <td>$populaarne</td>
    <td>$riik</td>
    <td>$gender</td>
</tr>";

        }
        ?>
        </tbody>
    </table>
    <h1>Add Name Data to JSON</h1>
    <a href="http://localhost:51040/NPT2/NPT2/jsonifail.json">vaadake result siin</a>
    <form method="POST" action="Display_Nimed.php">
        <label for="populaarne_nimi">Populaarne Nimi (%):</label><br>
        <input type="text" name="populaarne_nimi" required><br>

        <label for="riik_nimi">Riik (Country):</label><br>
        <input type="text" name="riik_nimi" required><br>

        <label for="gender_nimi">Gender (male/female):</label><br>
        <input type="text" name="gender_nimi" required><br>

        <label for="id">ID:</label><br>
        <input type="number" name="id" required><br>

        <label for="first_name">First Name:</label><br>
        <input type="text" name="first_name" required><br>

        <label for="emakeelne_nimi">Emakeelne Nimi:</label><br>
        <input type="text" name="emakeelne_nimi" required><br>

        <label for="voorkeelne_nimi">Võõrkeelne Nimi:</label><br>
        <input type="text" name="voorkeelne_nimi" required><br>

        <button type="submit" name="submit">Add Data</button>
    </form>
    </body>
    </html>

<?php
// Output the buffered content
echo ob_get_clean();
?>
