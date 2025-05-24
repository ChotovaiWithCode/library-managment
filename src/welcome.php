<?php
session_start();
$statusMessage = '';

$borrow_id = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save'])) {
        include 'database.php';

        $unit = $_POST['allow_rental_unit'];
        $fine = $_POST['overdue_fine'];
        $limit = $_POST['borrow_limit'];

        $stmt = $conn->prepare("INSERT INTO rental_policy (allow_rental_unit, overdue_fine, borrow_limit) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $unit, $fine, $limit);

        if ($stmt->execute()) {
             echo "<script>alert('Operation successfully');</script>";
        } else {
           echo"<script>alart('Error: ". $stmt->error."');</script>";
        }

        
    } elseif (isset($_POST['cancel'])) {
        echo "<script>alert('Operation cancelled');</script>";
    }
}
if (isset($_POST['cancel'])) {
        // Cancel button clicked - redirect or clear form
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['add'])) {
        // Add button clicked - process form
        $title = $_POST['title'];
        $class_no = $_POST['class_no'];
        $shelf_loc = $_POST['shelf_loc'];
        $booksid = $_POST['books_id'];
        $author = $_POST['author'];

        // DB connection (update with your credentials)
       
        include 'database.php';

        $stmt = $conn->prepare("INSERT INTO reference_books (title, class_no, shelf_location, books_id, author) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $class_no, $shelf_loc, $booksid, $author);

        if ($stmt->execute()) {
            echo "<script>alert('Reference book added successfully');</script>";
        } else {
            echo "<script>alert('Error adding book: " . $stmt->error . "');</script>";
        }
      
        $stmt->close();
        $conn->close();
    }
?>
<?php

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: access_denied.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DEF Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    @keyframes pulse-scale {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .animate-pulse-scale {
        animation: pulse-scale 4s infinite ease-in-out;
    }
    </style>
</head>

<body class="bg-blue-50 font-sans text-blue-900">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Mobile Header -->
        <header class="md:hidden bg-white p-4 flex items-center justify-between border-b">
        <h1 class="text-xl font-semibold">DEF Library</h1>
        <button id="menuToggle" class="w-8 h-8  rounded">
            <a href="#"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bxs-book-reader text-4xl'></i>
            </a>
        </button>
    </header>

    <!-- Mobile Sidebar -->
    <div id="mobileSidebar"
        class="fixed top-0 right-0 h-full w-20 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-50 md:hidden overflow-y-auto ">

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="p-2 flex flex-col items-center space-y-6 mt-10">
            <a href="welcome.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx  bx-book-bookmark text-4xl'></i> 
                <span class="text-sm font-medium">Library</span>
            </a>

            <a href="my_dashboard.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                 <i class='bx bx-share-alt text-4xl'></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <a href="resources.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bx-book-open text-4xl'></i>
                <span class="text-sm font-medium">Resources</span>
            </a>
             <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>

            <a href="bookscollection.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bxs-book text-4xl'></i>
                <span class="text-sm font-medium">Books</span>
            </a>

            <a href="members.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bx-group text-4xl'></i>
                <span class="text-sm font-medium">Member</span>
            </a>

            <?php endif; ?>

            <a href="settings.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bx-cog text-4xl'></i>
                <span class="text-sm font-medium">Settings</span>
            </a>

            <a href="logout.php" class="flex flex-col items-center text-center space-y-1 hover:text-red-600 transition">
                <i class='bx bx-log-out text-4xl'></i>
                <span class="text-sm font-medium">Logout</span>
            </a>
        </div>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 md:hidden"></div>

    
<div class="flex">
    <!-- Sidebar (Desktop - Fixed) -->
    <div class="hidden md:fixed sm:fixed md:flex w-20 h-screen bg-white border-r flex-col items-center py-4 space-y-10">
        <div class="w-8 h-8 rounded flex flex-col items-center justify-center mt-6">
            <a href="" class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bxs-book-reader text-4xl'></i>
            </a>
        </div>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <!-- Admin-visible links -->
            <div class="w-8 h-8 rounded flex flex-col items-center justify-center mt-6">
            <a href="welcome.php" class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx  bx-book-bookmark text-4xl'></i> 
                 <span class="text-sm font-medium">Library</span>
            </a>
        </div>

            <a href="my_dashboard.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-share-alt text-4xl'></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <a href="resources.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-book-open text-4xl'></i>
                <span class="text-sm font-medium">Resources</span>
            </a>

        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
            <!-- User-visible links -->
            <a href="members.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-group text-4xl'></i>
                <span class="text-sm font-medium">Member</span>
            </a>

            <a href="bookscollection.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bxs-book text-4xl'></i>
                <span class="text-sm font-medium">Books</span>
            </a>

            <a href="user_store.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-store text-4xl'></i>
                <span class="text-sm font-medium">Store</span>
            </a>
        <?php endif; ?>

        <!-- Common to both roles -->
        <a href="settings.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
            <i class='bx bx-cog text-4xl'></i>
            <span class="text-sm font-medium">Settings</span>
        </a>

        <a href="logout.php" class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-red-600 transition">
            <i class='bx bx-log-out text-4xl'></i>
            <span class="text-sm font-medium">Logout</span>
        </a>
    </div>
</div>

        <!-- Main Content -->
        <div class="flex-1 p-4 md:p-10 md:ml-20">
            <h1 class="text-3xl font-bold mb-6 hidden md:block">Welcome to DEF library</h1>

            <!-- Responsive Layout -->
            <div class="flex flex-col lg:flex-row justify-between gap-6">
                <!-- Left Column -->
                <div class="flex-1 space-y-6">
                    <!-- Library Settings -->
                    <form method="POST" action="">
                        <div class="bg-white p-4 rounded-lg shadow w-full">
                            <h2 class="text-lg font-semibold mb-3">Library Settings</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div class="flex items-center gap-2">
                                    <label class="text-sm font-medium w-40">Allowed Rental Units:</label>
                                    <input type="text" name="allow_rental_unit" class="border p-2 rounded w-full"
                                        placeholder="e.g. Books">
                                </div>
                                <div class="flex items-center gap-2">
                                    <label class="text-sm font-medium w-40">Overdue Fine:</label>
                                    <input type="text" name="overdue_fine" class="border p-2 rounded w-full"
                                        placeholder="e.g. 1.5">
                                </div>
                                <div class="flex items-center gap-2">
                                    <label class="text-sm font-medium w-40">Borrow Limit:</label>
                                    <input type="text" name="borrow_limit" class="border p-2 rounded w-full"
                                        placeholder="e.g. 5">
                                </div>
                            </div>
                            <div class="space-x-4">
                                <button type="submit" name="save"
                                    class="bg-blue-900 text-white px-4 py-2 rounded">Save</button>
                                <button type="submit" name="cancel"
                                    class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                            </div>
                        </div>
                    </form>


                    <!-- Add Book -->
                    <form method="POST" action="">
                        <div class="bg-white p-4 rounded-lg shadow w-full">
                            <h2 class="text-lg font-semibold mb-3">Add Reference Book</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div class="flex items-center gap-2">
                                    <label class="text-sm font-medium w-24">Title:</label>
                                    <input type="text" name="title" class="border p-2 rounded w-full"
                                        placeholder="Book Title" required>
                                </div>
                                <div class="flex items-center gap-2">
                                    <label class="text-sm font-medium w-24">Class No:</label>
                                    <input type="text" name="class_no" class="border p-2 rounded w-full"
                                        placeholder="Class No" required>
                                </div>
                                <div class="flex items-center gap-2">
                                    <label class="text-sm font-medium w-24">Shelf Loc.:</label>
                                    <input type="text" name="shelf_loc" class="border p-2 rounded w-full"
                                        placeholder="Shelf location" required>
                                </div>
                                <div class="flex items-center gap-2">
                                    <label class="text-sm font-medium w-24">Books ID:</label>
                                    <input type="text" name="books_id" class="border p-2 rounded w-full"
                                        placeholder="Books ID" required>
                                </div>
                                <div class="flex items-center gap-2">
                                    <label class="text-sm font-medium w-24">Author:</label>
                                    <input type="text" name="author" class="border p-2 rounded w-full"
                                        placeholder="Author" required>
                                </div>
                            </div>
                            <div class="space-x-4">
                                <button type="submit" name="add"
                                    class="bg-blue-900 text-white px-4 py-2 rounded">Add</button>
                                <button type="submit" name="cancel"
                                    class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                            </div>
                        </div>
                    </form>

                </div>

                <!-- Right Column (Image) -->
                <div class="flex justify-center items-center w-full lg:w-[40%]">
                    <img id="blinkingImage" src="img/booksdd.png" alt="booksadd"
                        class="max-h-[500px] w-auto animate-pulse-scale">
                </div>
            </div>

            <!-- Reference List -->
            <div class=" p-4 mt-10 ">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Reference lists</h2>


                    <form id="filterForm" method="GET" action="">
                        <select name="filter"
                            class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            onchange="document.getElementById('filterForm').submit()">
                            <option disabled selected>See more</option>
                            <option value="recent"
                                <?= isset($_GET['filter']) && $_GET['filter'] === 'recent' ? 'selected' : '' ?>>Recently
                                Added</option>
                            <option value="popular"
                                <?= isset($_GET['filter']) && $_GET['filter'] === 'popular' ? 'selected' : '' ?>>Most
                                Borrowed</option>
                            <option value="available"
                                <?= isset($_GET['filter']) && $_GET['filter'] === 'available' ? 'selected' : '' ?>>
                                Available Only</option>
                            <option value="all"
                                <?= isset($_GET['filter']) && $_GET['filter'] === 'all' ? 'selected' : '' ?>>View All
                            </option>
                        </select>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full ">
                        <thead>
                            <tr class="bg-blue-900 text-white">
                                <th class="py-2 px-2 sm:px-4 border text-left">Class No</th>
                                <th class="py-2 px-2 sm:px-4 border text-left hidden sm:table-cell">Books_id</th>
                                <th class="py-2 px-2 sm:px-4 border text-left">Shelf</th>
                                <th class="py-2 px-2 sm:px-4 border text-left">Title</th>
                                <th class="py-2 px-2 sm:px-4 border text-left hidden md:table-cell">Author</th>
                                <th class="py-2 px-2 sm:px-4 border text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- for delete form -->
                            <form id="deleteForm" action="delete_borrow.php" method="POST" style="display:none;">

                                <input type="hidden" name="id" id="deleteId">
                            </form>

                            <?php

                              // getdata to database
                              include 'database.php';
                            $sql = "SELECT books_id, class_no, shelf_location, title, author FROM reference_books;";
                            $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $serial = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='border-t'>";
                            echo "<td class='py-2 px-2 sm:px-4'>" . htmlspecialchars($row['class_no']) . "</td>";
                            echo "<td class='py-2 px-2 sm:px-4'>" . htmlspecialchars($row['books_id']) . "</td>";
                            echo "<td class='py-2 px-2 sm:px-4'>" . htmlspecialchars($row['shelf_location']) . "</td>";
                            echo "<td class='py-2 px-2 sm:px-4'>" . htmlspecialchars($row['title']) . "</td>";
                            echo "<td class='py-2 px-2 sm:px-4 hidden md:table-cell'>" . htmlspecialchars($row['author']) . "</td>";
                            echo '<td class="py-2 px-2 sm:px-4 gap-3">';
                                   echo '<span class="bx bx-edit cursor-pointer text-lg"></span> ';  // edit icon

                                    echo '<span 
                                            class="bx bx-trash cursor-pointer text-lg text-red-600" 
                                            onclick="confirmDelete(\'' . $row['books_id'] . '\')" 
                                            title="Delete">
                                        </span>';

                                    echo '<span 
                                            class="bx bx-dots-horizontal-rounded text-lg text-yellow-600 cursor-pointer" 
                                            onclick="openRestrictModal(' . htmlspecialchars(json_encode($row['books_id'])) . ', \'' . htmlspecialchars($row['title'], ENT_QUOTES) . '\')">
                                        </span>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='py-4 text-center text-gray-500'>No reference books found.</td></tr>";
                    }
                    $conn->close();
                    ?>
                        </tbody>
                    </table>
                </div>
                <!-- deleteconformation -->
                <div id="confirmModal"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white p-6 rounded shadow-xl max-w-sm w-full">
                        <h2 class="text-lg font-semibold mb-4">Delete Record?</h2>
                        <p class="mb-4">Are you sure you want to delete this record?</p>
                        <div class="flex justify-end space-x-3">
                            <button onclick="closeModal()"
                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">No</button>
                            <button onclick="submitDelete()"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Yes</button>
                        </div>
                    </div>
                </div>


                <!-- Pagination -->
                <div class="mt-6 flex justify-between">
                    <button class="bg-gray-300 px-4 py-2 rounded">Skip</button>
                    <button class="bg-blue-900 text-white px-4 py-2 rounded">Next</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    const menuBtn = document.getElementById("menuToggle");
    const sidebar = document.getElementById("mobileSidebar");
    const overlay = document.getElementById("overlay");

    menuBtn.addEventListener("click", () => {
        sidebar.classList.toggle("translate-x-full");
        overlay.classList.toggle("hidden");
    });

    overlay.addEventListener("click", () => {
        sidebar.classList.add("translate-x-full");
        overlay.classList.add("hidden");
    });
    //for deletion
    let deleteBookId = null;

    function confirmDelete(bookId) {
        deleteBookId = bookId;
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        deleteBookId = null;
    }

    function submitDelete() {
        if (deleteBookId) {
            document.getElementById('deleteId').value = deleteBookId;
            document.getElementById('deleteForm').submit();
        }
    }
    </script>
</body>

</html>