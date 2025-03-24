<?php
include 'config.php';

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM books WHERE name LIKE '%$search%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td class='border border-gray-300 px-4 py-2'>{$row['id']}</td>
                    <td class='border border-gray-300 px-4 py-2'>{$row['name']}</td>
                    <td class='border border-gray-300 px-4 py-2'>{$row['description']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3' class='text-center py-2'>No results found</td></tr>";
    }
}
?>