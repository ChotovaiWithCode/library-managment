<?php
include('database.php');

// Search filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM products WHERE name LIKE '%$search%' OR description LIKE '%$search%'  LIMIT 8";
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
    <link href="./output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="./custom.css" rel="stylesheet">
    <style>
        .list-item.active::before {
            content: "→";
            color: #22d3ee;
            position: absolute;
            left: -20px;
        }
    </style>
</head>

<body class="bg-gray-100 flex justify-center">

    <!-- Left Part (Always Visible) -->
    <div id="libraryItem" class="bg-gray-200 p-10 w-[235px] h-[925px]">
        <h1 class="text-3xl font-bold mt-[20px] mb-10 text-left">BOOKS</h1>
        <ul class="space-y-3 text-lg text-gray-500">
            <li class="list-item w-[200px] h-[30px] cursor-pointer transition-all duration-300 relative active"
                onclick="activateItem(this);toggleCategoryDetails('details');">
                Library
            </li>
            <li class="list-item w-[200px] h-[30px] cursor-pointer transition-all duration-300 relative"
                onclick="activateItem(this);toggleCategoryDetails('additems');">
                Add Items
            </li>
            <li class="list-item w-[200px] h-[30px] cursor-pointer transition-all duration-300 relative"
                onclick="activateItem(this);toggleCategoryDetails('addcollection');">
                Add Collection
            </li>
            <li class="list-item w-[200px] h-[30px] cursor-pointer transition-all duration-300 relative"
                onclick="activateItem(this);toggleCategoryDetails('post');">
                Post
            </li>
            <li class="list-item w-[200px] h-[30px] cursor-pointer transition-all duration-300 relative"
                onclick="activateItem(this);toggleCategoryDetails('controle');">
                Controle
            </li>
        </ul>
        <ul class="mt-10 space-y-3 text-lg text-gray-500">
            <li class="list-item w-[200px] h-[30px] cursor-pointer transition-all duration-300 relative"
                onclick="activateItem(this);toggleCategoryDetails('settings');">
                Settings
            </li>
            <li class="list-item w-[200px] h-[30px] cursor-pointer transition-all duration-300 relative"
                onclick="activateItem(this);toggleCategoryDetails('support');">
                Support
            </li>
            <li class="list-item w-[200px] h-[30px] cursor-pointer  transition-all duration-300 relative"
                onclick="activateItem(this);toggleCategoryDetails('sair');">
                Sair
            </li>
        </ul>
    </div>

    <!-- Right Part (Sections to Toggle) -->
    <div id="catagorydetails" class="flex-1 p-6 md:p-9">
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
                <div class="filter flex items-center justify-center bg-cyan-500 rounded-lg gap-1 p-2">
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
                    placeholder="Search your books" value="<?php echo htmlspecialchars($search); ?>" />
                <button type="submit"
                    class="absolute right-4 top-4 text-3xl cursor-pointer text-gray-500">
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

    <!-- Add Items Section -->
    <div id="catagoryadditems" class="flex-1 p-6 md:p-9 hidden">
  <h1>Add items</h1>
    </div>

    <!-- Add Collection Section -->
    <div id="catagoryaddcollection" class="flex-1 p-6 md:p-9 hidden">
        <h1>Add Collection Section</h1>
    </div>

    <!-- Post Section -->
    <div id="catagorypost" class="flex-1 p-6 md:p-9 hidden">
        <h1>Post Section</h1>
    </div>

    <!-- Controle Section -->
    <div id="catagorycontrole" class="flex-1 p-6 md:p-9 hidden">
        <h1>Controle Section</h1>
    </div>

    <!-- Settings Section -->
    <div id="catagorysettings" class="flex-1 p-6 md:p-9 hidden">
        <h1>Settings Section</h1>
    </div>

    <!-- Support Section -->
    <div id="catagorysupport" class="flex-1 p-6 md:p-9 hidden">
        <h1>Support Section</h1>
    </div>

    <!-- Sair Section -->
    <div id="catagorysair" class="flex-1 p-6 md:p-9 hidden">
        <h1>Sair Section</h1>
    </div>

    <script src="library-page.js">
      
        
    </script>
</body>

</html>