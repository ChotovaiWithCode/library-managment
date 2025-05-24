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
        <main class="flex-1 p-6 md:ml-20">
            <div class="flex flex-col md:flex-row md:items-center md:justify-center gap-6 p-4 md:ml-20">
                <!-- Option Dropdown -->
                <div class="flex items-center gap-2">
                    <form method="GET" id="filterForm">
                        <select name="sort" id="option" class="border p-2 rounded"
                            onchange="document.getElementById('filterForm').submit()">
                            <option value="">All books</option>
                            <option value="most_borrowed"
                                <?= isset($_GET['sort']) && $_GET['sort'] === 'most_borrowed' ? 'selected' : '' ?>>Most
                                borrowed</option>
                            <option value="newest"
                                <?= isset($_GET['sort']) && $_GET['sort'] === 'newest' ? 'selected' : '' ?>>Newest
                            </option>
                        </select>
                    </form>

                </div>

                <!-- Member ID -->
                <div class="flex items-center gap-2">
                    <label for="memberId" class="text-sm font-medium">Keywords:</label>
                    <input id="memberId" type="text" class="border p-2 rounded" placeholder="">
                </div>

                <!-- Quantity -->
                <input type="number" placeholder="Qty" class="border p-2 rounded w-20" />

                <!-- Search Button -->
                <button class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800">Search</button>
            </div>

            <h1 class="text-3xl font-bold mb-6">Categories</h1>

            <!-- Stats cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7 mb-6">
                <div class="bg-blue-900 rounded-xl shadow p-6 gap-3 flex items-center">
                    <i class='bx bxs-book-open text-white text-6xl -rotate-45'></i>
                    <i class='bx bxs-book-open text-white text-6xl rotate-45'></i>
                    <p class="font-bold text-2xl text-white">All book</p>
                </div>


                <div class="bg-orange-600 rounded-xl shadow p-6 gap-3 flex items-center">
                    <form method="GET" action="">
                        <button type="submit" name="sort" value="most_borrowed" class="w-full">
                            <div
                                class="bg-orange-600 rounded-xl  p-2 gap-3 flex items-center cursor-pointer hover:bg-orange-500 transition">
                                <i class='bx bxs-book-open text-white text-6xl -rotate-45'></i>
                                <i class='bx bxs-book-open text-white text-6xl rotate-45'></i>
                                <p class="font-bold text-2xl text-white">Most borrower</p>
                            </div>
                        </button>
                    </form>

                </div>


                <div class="bg-blue-900 rounded-xl shadow p-6 gap-3 flex items-center">
                    <form method="GET" action="">
                        <button type="submit" name="sort" value="newest" class="w-full">
                            <div
                                class="bg-blue-900 rounded-xl  p-2 gap-3 flex items-center cursor-pointer hover:bg-blue-800 transition">
                                <i class='bx bxs-book-open text-white text-6xl -rotate-45'></i>
                                <i class='bx bxs-book-open text-white text-6xl rotate-45'></i>
                                <p class="font-bold text-2xl text-white">Newest</p>
                            </div>
                        </button>
                    </form>
                </div>
            </div>

            <h2 class="text-2xl font-semibold mb-6">All books</h2>
            <div id="bookGrid" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

                <!-- PHP: Display books -->
                <?php
                include 'database.php';
                // pagination
                $limit = 12; // Books per page
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                if ($page < 1) $page = 1;
                $offset = ($page - 1) * $limit;

                // Sort logic
                $sortQuery = "";
                if (isset($_GET['sort'])) {
                    if ($_GET['sort'] === 'newest') {
                        $sortQuery = "ORDER BY date_added DESC";
                    } elseif ($_GET['sort'] === 'most_borrowed') {
                        $sortQuery = "ORDER BY borrow_count DESC";
                    }
                }

                // Count total books
                $countSql = "SELECT COUNT(*) as total FROM bookscollection";
                $countResult = $conn->query($countSql);
                $totalBooks = $countResult->fetch_assoc()['total'];
                $totalPages = ceil($totalBooks / $limit);

                $sql = "SELECT * FROM bookscollection $sortQuery LIMIT $limit OFFSET $offset";
                $result = $conn->query($sql);

                // Display books
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        
                    
                ?>
                <div class="gap-3 flex items-center justify-center">
                    <div>
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Book"
                            class="h-48 mx-auto mb-4" />
                    </div>
                    <div>
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
                        <h3 class="font-semibold text-xl"><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p class="font-semibold text-sm text-gray-400">Total Qty:
                            <span><?php echo $row['total_quantity']; ?></span>
                        </p>
                        <p class="font-semibold text-sm text-gray-400">Available Qty:
                            <span><?php echo $row['available_quantity']; ?></span>
                        </p>

                        <!-- ADD TO CART FORM -->
                        <form method="POST" action="add_to_cart.php">
                            <input type="hidden" name="books_id" value="<?php echo $row['books_id']; ?>" />
                            <button type="submit" class="block mt-2 bg-blue-700 text-white px-4 py-1 rounded">Add to
                                cart</button>
                        </form>
                    </div>
                </div>

                <?php
                    }
                } else {
                    echo "<p>No books found.</p>";
                }

                $conn->close();
       
                ?>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-6 space-x-2">
                <!-- Left Arrow -->
                <a href="<?= ($page > 1) ? '?page=' . ($page - 1) . '&sort=' . ($_GET['sort'] ?? '') : '#' ?>"
                    class="px-3 py-1 border rounded <?= ($page == 1) ? 'pointer-events-none opacity-50' : '' ?>">
                    &lt;
                </a>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>&sort=<?= $_GET['sort'] ?? '' ?>"
                    class="px-3 py-1 border rounded <?= ($page == $i) ? 'bg-blue-700 text-white' : '' ?>">
                    <?= $i ?>
                </a>
                <?php endfor; ?>

                <!-- Right Arrow -->
                <a href="<?= ($page < $totalPages) ? '?page=' . ($page + 1) . '&sort=' . ($_GET['sort'] ?? '') : '#' ?>"
                    class="px-3 py-1 border rounded <?= ($page == $totalPages) ? 'pointer-events-none opacity-50' : '' ?>">
                    &gt;
                </a>
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
    </script>
</body>

</html>