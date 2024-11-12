<%@ Page Title="Home Page" Language="C#"  AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="NPT2._Default" %>

<html>
    <head>
        <title>xml ja xslt andmete kuvamine</title>
        <script type="text/javascript">
                    function sortTable(columnIndex) {
                        var table = document.querySelector('table');
                        var rows = Array.from(table.querySelectorAll('tr:nth-child(n+2)')); // Skip the header row
                        var ascending = table.getAttribute('data-order') === 'asc';
                        rows.sort(function(rowA, rowB) {
                            var cellA = rowA.cells[columnIndex].textContent.trim();
                            var cellB = rowB.cells[columnIndex].textContent.trim();
                            if (ascending) {
                                return cellA.localeCompare(cellB);
                            } else {
                                return cellB.localeCompare(cellA);
                            }
                        });
                        rows.forEach(function(row) {
                            table.appendChild(row); // Reorder the rows in the table
                        });
                        table.setAttribute('data-order', ascending ? 'desc' : 'asc'); // Toggle the order
                    }
                </script>
               <script>
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
        <h1>xml ja xslt andmete kuvamine</h1>
        <br />
        <div>
            <asp:Xml runat="server" DocumentSource="~/Nimed.xml"
                TransformSource="~/NimedLisa.xslt" />
        </div>
    </body>
</html>