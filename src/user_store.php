<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: access_denied.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Library Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body class="bg-blue-50 font-sans text-blue-900">

    <!-- Mobile Header -->
    <header class="md:hidden bg-white p-4 flex items-center justify-between border-b">
        <h1 class="text-xl font-semibold">DEF Library</h1>
        <button id="menuToggle" class="w-8 h-8  rounded">
            <a href="#" class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
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
        <div
            class="hidden md:fixed sm:fixed md:flex w-20 h-screen bg-white border-r flex-col items-center py-4 space-y-10">
            <div class="w-8 h-8 rounded flex flex-col items-center justify-center mt-6">
                <a href="" class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                    <i class='bx bxs-book-reader text-4xl'></i>
                </a>
            </div>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <!-- Admin-visible links -->
            <div class="w-8 h-8 rounded flex flex-col items-center justify-center mt-6">
                <a href="welcome.php"
                    class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                    <i class='bx  bx-book-bookmark text-4xl'></i>
                    <span class="text-sm font-medium">Library</span>
                </a>
            </div>

            <a href="my_dashboard.php"
                class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-share-alt text-4xl'></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <a href="resources.php"
                class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-book-open text-4xl'></i>
                <span class="text-sm font-medium">Resources</span>
            </a>

            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
            <!-- User-visible links -->
            <a href="members.php"
                class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-group text-4xl'></i>
                <span class="text-sm font-medium">Member</span>
            </a>

            <a href="bookscollection.php"
                class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bxs-book text-4xl'></i>
                <span class="text-sm font-medium">Books</span>
            </a>

            <a href="user_store.php"
                class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-store text-4xl'></i>
                <span class="text-sm font-medium">Store</span>
            </a>
            <?php endif; ?>

            <!-- Common to both roles -->
            <a href="settings.php"
                class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-cog text-4xl'></i>
                <span class="text-sm font-medium">Settings</span>
            </a>

            <a href="logout.php"
                class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-red-600 transition">
                <i class='bx bx-log-out text-4xl'></i>
                <span class="text-sm font-medium">Logout</span>
            </a>
        </div>
    </div>
    <!-- Main Content -->
    <main class="flex-1 p-6 md:ml-20">
        <h2 class="text-3xl font-bold mb-6">MY Store</h2>

        <div class="flex flex-col md:flex-row md:items-center md:justify-center gap-6 p-4 md:ml-20">
            <!-- Sort Dropdown -->
            <form method="GET" id="filterForm" class="flex items-center gap-2">
                <select name="sort" id="option" class="border p-2 rounded"
                    onchange="document.getElementById('filterForm').submit()">
                    <option value="">All books</option>
                    <option value="most_borrowed"
                        <?= isset($_GET['sort']) && $_GET['sort'] === 'most_borrowed' ? 'selected' : '' ?>>Most Borrowed
                    </option>
                    <option value="newest" <?= isset($_GET['sort']) && $_GET['sort'] === 'newest' ? 'selected' : '' ?>>
                        Newest</option>
                </select>
            </form>

            <!-- Keyword (Optional) -->
            <div class="flex items-center gap-2">
                <label for="keywords" class="text-sm font-medium">Keywords:</label>
                <input id="keywords" type="text" class="border p-2 rounded" placeholder="Search keywords">
            </div>

            <!-- Quantity (Optional UI) -->
            <input type="number" placeholder="Qty" class="border p-2 rounded w-20" />

            <!-- Search Button -->
            <button class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800">Search</button>
        </div>

        <h2 class="text-2xl font-semibold mb-6">All books</h2>

        <div id="bookGrid" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php
        include 'database.php';

        // Pagination
        $limit = 12;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max($page, 1);
        $offset = ($page - 1) * $limit;

        // Sorting
        $sortQuery = "";
        if (isset($_GET['sort'])) {
            if ($_GET['sort'] === 'newest') {
                $sortQuery = "ORDER BY date_added DESC";
            } elseif ($_GET['sort'] === 'most_borrowed') {
                $sortQuery = "ORDER BY borrow_count DESC";
            }
        }

        // Total count
        $countSql = "SELECT COUNT(*) as total FROM user_store";
        $countResult = $conn->query($countSql);
        $totalBooks = $countResult->fetch_assoc()['total'];
        $totalPages = ceil($totalBooks / $limit);

        // Fetch books
        $sql = "SELECT * FROM user_store $sortQuery LIMIT $limit OFFSET $offset";
        $result = $conn->query($sql);

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
            <div class="gap-3 flex items-center justify-center">
                <div>
                    <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Book" class="h-48 mx-auto mb-4" />
                </div>
                <div>
                    <!-- Rating Stars -->
                    <p class="text-lg">
                        <?php
                    $rating = (int)$row['rating'];
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $rating
                            ? '<i class="fas fa-star text-yellow-500"></i>'
                            : '<i class="fas fa-star text-gray-400"></i>';
                    }
                    ?>
                    </p>
                    <h3 class="font-semibold text-xl"><?= htmlspecialchars($row['title']) ?></h3>
                    <p class="font-semibold text-sm text-gray-400">Total Qty:
                        <span><?= $row['total_quantity'] ?></span>
                    </p>
                    <p class="font-semibold text-sm text-gray-400">Available Qty:
                        <span><?= $row['available_quantity'] ?></span>
                    </p>

                    <!-- Add to Cart -->
                    <!-- Return Book Button -->
                    <button onclick="openRatingModal(<?= $row['books_id'] ?>)"
                        class="bg-blue-700 text-white px-4 py-1 rounded">
                        Return Book
                    </button>

                    <!-- Rating Modal -->
                    <div id="ratingModal<?= $row['books_id'] ?>"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-80 text-center">
                            <h2 class="text-xl font-semibold mb-2">Rate this book</h2>
                            <p class="mb-4 text-gray-600">Thanks for reading! Please rate the book.</p>

                            <div class="flex justify-center mb-4 text-yellow-500 text-2xl"
                                id="stars<?= $row['books_id'] ?>">
                                <!-- Stars will be generated by JS -->
                            </div>

                            <form method="POST" action="return_book.php">
                                <input type="hidden" name="books_id" value="<?= $row['books_id'] ?>">
                                <input type="hidden" name="rating" id="ratingInput<?= $row['books_id'] ?>">
                                <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded">Submit</button>
                                <button type="button" class="ml-2 bg-gray-400 text-white px-4 py-1 rounded"
                                    onclick="closeRatingModal(<?= $row['books_id'] ?>)">
                                    Cancel
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <?php
            endwhile;
        else:
            echo "<p>No books found.</p>";
        endif;

        $conn->close();
        ?>
        </div>

       
       


        <!-- Pagination -->
        <div class="flex justify-center mt-6 space-x-2">
            <a href="<?= ($page > 1) ? '?page=' . ($page - 1) . '&sort=' . ($_GET['sort'] ?? '') : '#' ?>"
                class="px-3 py-1 border rounded <?= ($page == 1) ? 'pointer-events-none opacity-50' : '' ?>">&lt;</a>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&sort=<?= $_GET['sort'] ?? '' ?>"
                class="px-3 py-1 border rounded <?= ($page == $i) ? 'bg-blue-700 text-white' : '' ?>">
                <?= $i ?>
            </a>
            <?php endfor; ?>

            <a href="<?= ($page < $totalPages) ? '?page=' . ($page + 1) . '&sort=' . ($_GET['sort'] ?? '') : '#' ?>"
                class="px-3 py-1 border rounded <?= ($page == $totalPages) ? 'pointer-events-none opacity-50' : '' ?>">&gt;</a>
        </div>
    </main>

    </div>

    <script>
    // Mobile Sidebar Toggle
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
    //    for rating
    function openRatingModal(bookId) {
    document.getElementById('ratingModal' + bookId).classList.remove('hidden');
    renderStars(bookId, 0); // Default unselected
}

function closeRatingModal(bookId) {
    document.getElementById('ratingModal' + bookId).classList.add('hidden');
}

function renderStars(bookId, selectedRating) {
    const starContainer = document.getElementById('stars' + bookId);
    const ratingInput = document.getElementById('ratingInput' + bookId);
    starContainer.innerHTML = '';

    for (let i = 1; i <= 5; i++) {
        const star = document.createElement('span');
        star.innerHTML = '&#9733;';
        star.classList.add(i <= selectedRating ? 'text-yellow-500' : 'text-gray-300', 'cursor-pointer');
        star.onclick = () => {
            ratingInput.value = i;
            renderStars(bookId, i);
        };
        starContainer.appendChild(star);
    }
}
    </script>

</body>

</html>