<?php
session_start();
include 'database.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch member info
$sql = "SELECT name, member_id, quantity FROM member_info WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$member = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
      <link rel="shortcut icon" type="x-icon" href="img/library-managment.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Borrowed List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-blue-50 font-sans text-blue-900">

    <!-- Mobile Header -->
    <header class="md:hidden bg-white p-4 flex items-center justify-between border-b">
        <h1 class="text-xl font-semibold">DEF Library</h1>
        <button id="menuToggle" class="w-8 h-8 rounded">
            <a href="welcome.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bxs-book-reader text-4xl'></i>
            </a>
        </button>
    </header>

    <!-- Mobile Sidebar -->
    <div id="mobileSidebar"
        class="fixed top-0 right-0 h-full w-20 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-50 md:hidden overflow-y-auto">
        <div class="p-2 flex flex-col items-center space-y-6 mt-10">
            <a href="my_dashboard.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bxs-book-reader text-4xl'></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

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

            <a href="resources.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx bx-book-open text-4xl'></i>
                <span class="text-sm font-medium">Resources</span>
            </a>
            <a href="user_store.php"
                class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                <i class='bx  bx-store text-4xl'></i>
                <span class="text-sm font-medium">Store</span>
            </a>

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
            <!-- Dashboard Logo (optional logo, no link needed) -->
            <div class="w-8 h-8 rounded flex flex-col items-center justify-center mt-6">
                <a href="welcome.php"
                    class="flex flex-col items-center text-center space-y-1 hover:text-blue-600 transition">
                    <i class='bx bxs-book-reader text-4xl'></i>
                </a>
            </div>


            <a href="my_dashboard.php"
                class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-share-alt text-4xl'></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <a href="bookscollection.php"
                class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bxs-book text-4xl'></i>
                <span class="text-sm font-medium">Books</span>
            </a>

            <a href="members.php"
                class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-group text-4xl'></i>
                <span class="text-sm font-medium">Member</span>
            </a>

            <a href="resources.php"
                class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx bx-book-open text-4xl'></i>
                <span class="text-sm font-medium">Resources</span>
            </a>
            <a href="user_store.php"
                class="w-8 h-8 rounded flex flex-col items-center justify-center hover:text-blue-600 transition">
                <i class='bx  bx-store text-4xl'></i>
                <span class="text-sm font-medium">Store</span>
            </a>

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

        </div>>

        <!-- Main Content -->
        <main class="w-full md:ml-20 pt-20 md:pt-6 px-4">
            <h2 class="text-3xl font-bold mb-6">Allison’s borrowed list</h2>

            <!-- Book Card -->
            <?php


if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $book) {
?>
            <div class="bg-white p-4 rounded-lg shadow-md mb-4 flex gap-4 items-start">
                <img src="<?php echo htmlspecialchars($book['image_url']); ?>"
                    alt="<?php echo htmlspecialchars($book['title']); ?>" class="w-20 h-28 object-cover rounded-md">
                <div class="flex-1">
                    <p class="text-yellow-500">
                        <?php
            $rating = (int)$book['rating'];
            for ($i = 1; $i <= 5; $i++) {
                echo $i <= $rating ? '★' : '☆';
            }
            ?>
                    </p>
                    <h3 class="font-bold text-xl mb-3"><?php echo htmlspecialchars($book['title']); ?></h3>
                    <div class="grid grid-cols-3 gap-4 text-md font-semibold">
                        <p>Resource ID: <?php echo $book['books_id']; ?></p>
                        <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
                        <p>Total Qty: <?php echo $book['total_quantity']; ?></p>
                        <p>Available Qty: <?php echo $book['available_quantity']; ?></p>
                        <p>Membership time:
                            <?php echo $member ? htmlspecialchars($member['quantity']) . ' months' : 'N/A'; ?></p>
                        <p>Borrowed by: <?php echo $member ? htmlspecialchars($member['name']) : 'N/A'; ?></p>
                        <p>Member ID: <?php echo $member ? htmlspecialchars($member['member_id']) : 'N/A'; ?></p>
                    </div>
                </div>
                <form method="POST" action="remove_from_cart.php">
                    <input type="hidden" name="books_id" value="<?php echo $book['books_id']; ?>" />
                    <button class="text-gray-400 hover:text-red-600 text-2xl font-bold">&times;</button>
                </form>
            </div>
            <?php
    }
} else {
    echo "<p>No books in cart.</p>";
}
?>



            <!-- Action Buttons -->
            <div class="mt-6 flex gap-4 float-right">
                <!-- Action Buttons -->
                <form method="POST" action="borrow_books.php" class="mt-6 flex gap-4 float-right">
                    <button name="borrow"
                        class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800">Borrow</button>
                    <button name="cancel"
                        class="bg-gray-200 text-gray-800 px-6 py-2 rounded hover:bg-gray-300">Cancel</button>
                </form>


            </div>

    </div>
    </div>

</body>

</html>