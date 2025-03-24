<?php
include('database.php');

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Search filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM products WHERE name LIKE '%$search%' OR description LIKE '%$search%'";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sapiens Library</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-gray-100 flex flex-col md:flex-row">

    <!-- Left Part -->
    <div id="catagoryItem" class="bg-gray-200 p-4 md:p-10 w-full md:w-64 lg:w-72 h-auto md:h-screen">
        <h1 class="text-3xl font-bold mt-4 mb-8 text-left">BOOKS</h1>
        <ul class="space-y-3 text-lg text-gray-500">
            <li id="libraryItem" class="list-item cursor-pointer transition-all duration-300 active" onclick="toggleCategoryDetails('library')">
                Library
            </li>
            <li class="list-item cursor-pointer transition-all duration-300" onclick="activateItem(this)">
                Add Items
            </li>
            <li class="list-item cursor-pointer transition-all duration-300" onclick="activateItem(this)">
                Add Collection
            </li>
            <li class="list-item cursor-pointer transition-all duration-300" onclick="activateItem(this)">
                Post
            </li>
            <li class="list-item cursor-pointer transition-all duration-300" onclick="activateItem(this)">
                Controle
            </li>
        </ul>
        <ul class="mt-8 space-y-3 text-lg text-gray-500">
            <li class="list-item cursor-pointer transition-all duration-300" onclick="activateItem(this)">
                Settings
            </li>
            <li class="list-item cursor-pointer transition-all duration-300" onclick="activateItem(this)">
                Support
            </li>
            <li class="list-item cursor-pointer transition-all duration-300" onclick="activateItem(this)">
                Sair
            </li>
        </ul>
    </div>

    <!-- Right Part -->
    <div id="catagorydetails" class="flex-1 p-4 md:p-9">
        <!-- Search Bar -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-6">
            <div class="flex items-center gap-4 mb-4 md:mb-0">
                <i class='bx bx-search-alt-2 text-3xl p-2 cursor-pointer'></i>
                <h1 class="text-lg font-semibold">Start looking...</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center border-2 border-gray-300 rounded-lg gap-1 p-2">
                    <i class='bx bx-grid-horizontal text-xl'></i>
                    <p class="text-lg">Preencher</p>
                </div>
                <div class="flex items-center justify-center border-2 border-gray-300 rounded-lg gap-1 p-2">
                    <i class='bx bx-menu-alt-left text-xl'></i>
                    <p class="text-lg">Qualification</p>
                </div>
                <div class="flex items-center justify-center bg-green-500 rounded-lg gap-1 p-2">
                    <i class='bx bx-filter text-xl text-white'></i>
                    <p class="text-lg text-white">Filter</p>
                </div>
            </div>
        </div>

        <!-- Search Input -->
        <form action="" method="GET" class="w-full mb-6">
            <div class="relative">
                <input id="Titlebooks" name="search"
                    class="w-full p-4 text-2xl font-bold border border-gray-300 rounded-lg"
                    placeholder="Search your books" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="absolute right-4 top-4 text-3xl cursor-pointer">
                    <i class='bx bx-search-alt-2'></i>
                </button>
            </div>
        </form>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if (empty($products)): ?>
                <p class="text-center text-gray-600 col-span-full">No products found.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="flex items-center justify-center p-4">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>"
                                alt="<?php echo htmlspecialchars($product['name']); ?>"
                                class="h-48 w-36 object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </h3>
                            <p class="text-sm text-gray-600 mt-2">
                                <?php echo htmlspecialchars($product['description']); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Function to toggle the visibility of the category details section
        function toggleCategoryDetails(category) {
            const categoryDetails = document.getElementById('catagorydetails');

            if (category === 'library') {
                categoryDetails.classList.remove('hidden'); // Show the section
            } else {
                categoryDetails.classList.add('hidden'); // Hide the section
            }
        }

        // Function to activate list items
        function activateItem(item) {
            const listItems = document.querySelectorAll('.list-item');
            listItems.forEach(li => li.classList.remove('active'));
            item.classList.add('active');
        }

        // Automatically activate the "Library" item on page load
        document.addEventListener('DOMContentLoaded', function () {
            const libraryItem = document.getElementById('libraryItem');
            activateItem(libraryItem); // Set "Library" as active
            toggleCategoryDetails('library'); // Show the category details section
        });
    </script>
    <script src="library-page.js"></script>
</body>

</html>