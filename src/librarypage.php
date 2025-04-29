<?php

session_start();

// Check if user is registered
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: Seassionstart.php"); // Redirect to your registration page
    exit();
}
include('database.php');

// Search filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM products WHERE books_name LIKE '%$search%' OR description LIKE '%$search%'  LIMIT 8";
$result = $conn->query($sql);


$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// collection Search filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$collections = "SELECT * FROM transactions WHERE books_name LIKE '%$search%' OR description LIKE '%$search%'  LIMIT 8";
$collresult = $conn->query($collections);
$collection = [];

if ($collresult->num_rows > 0) {
    while ($row = $collresult->fetch_assoc()) {
        $collection[] = $row;
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
                onclick="activateItem(this);toggleCategoryDetails('orderbooks');">
                Orderbooks
            </li>
            <li class="list-item w-[200px] h-[30px] cursor-pointer transition-all duration-300 relative"
                onclick="activateItem(this);toggleCategoryDetails('returnbooks');">
                Returnbooks
            </li>
            <li class="list-item w-[200px] h-[30px] cursor-pointer transition-all duration-300 relative disabled:"
            >
            <!-- onclick="activateItem(this);toggleCategoryDetails('post');" -->
                
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
                onclick="activateItem(this);toggleCategoryDetails('collection');">
                Collection
            </li>

        </ul>
        <ul class="mt-96 space-y-3 text-lg text-gray-500">
            <li id="logoutbtn" class="list-item w-[200px] h-[30px] cursor-pointer   relative"
                onclick="window.location.href='logout.php'" ;>
                Logout
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
                <button type="submit" class="absolute right-4 top-4 text-3xl cursor-pointer text-gray-500">
                    <i class='bx bx-search-alt-2'></i>
                </button>
            </div>
        </form>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
        onclick="activateItem(this);toggleCategoryDetails('post');">
            <?php if (empty($products)): ?>
            <p class="text-center text-gray-600 col-span-full">No products found.</p>
            <?php else: ?>
            <?php foreach ($products as $product): ?>
            <div id="bookdetails" class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer"
             >
                <div class="flex items-center justify-center p-4">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>"
                        alt="<?php echo htmlspecialchars($product['books_name']); ?>" class="h-48 w-36 object-cover">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <?php echo htmlspecialchars($product['books_name']); ?>
                        
                    </h3>
                    <h1 class="text-lg font-semibold italic underline text-gray-800">
                        Rating :
                    <?php echo htmlspecialchars($product['rating']) ; ?>
                    </h1>
                    
                    <p class="text-sm text-gray-600 mt-2">
                        <?php echo htmlspecialchars($product['description']); ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- order Section -->
    <div id="catagoryorderbooks" class="flex-1  p-6 md:p-9 hidden">

        <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Book Order Form</h2>
            <div class="line bg-gray-600 h-1 w-full"></div>

            <form action="borrowProcess.php" method="POST" class="space-y-5">

                <!-- Full Name -->
                <div class=" my-7">
                    <label for="full_name" class="block font-medium text-gray-700">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" required
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Email -->
                <div class=" my-7">
                    <label for="email" class="block font-medium text-gray-700">Email Address:</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Phone Number -->
                <div class=" my-7">
                    <label for="phone" class="block font-medium text-gray-700">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" required
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Product Name -->
                <div class=" my-7">
                    <label for="product_name" class="block font-medium text-gray-700">Books Name:</label>
                    <input type="text" id="product_name" name="books_name" required
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Quantity -->
                <div class=" my-7">
                    <label for="quantity" class="block font-medium text-gray-700">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" required
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Return Date -->
                <div class=" my-7">
                    <label for="return_date" class="block font-medium text-gray-700">Return Date:</label>
                    <input type="date" id="return_date" name="return_date" required
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400">
                </div>

                <div class=" my-7">
                    <label for="description" class="block font-medium text-gray-700">Description:</label>
                    <textarea id="description" name="description" rows="3" required
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-all w-full">
                    Submit Order
                </button>

            </form>
        </div>
    </div>

    <!-- Add Collection Section -->
    <div id="catagoryreturnbooks" class="flex-1 p-6 md:p-9 hidden">
        <form action="return_product.php" method="POST" class=" p-8 bg-white rounded-lg  w-full max-w-3xl m-auto mt-7">
            <h2 class="text-2xl font-bold text-center mb-6">Book Return Form</h2>
            <div class="line bg-gray-600 h-1 w-full"></div>

            <div class=" my-6">
                <label for="email" class="block font-medium text-gray-700">Email Address:</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Phone Number -->
            <div class=" my-6">
                <label class="block mb-2 font-medium">Borrow ID</label>
                <input type="text" name="borrow_id" required class="w-full px-4 py-2 border rounded mb-4">
            </div>

            <!-- books Name -->
            <div class=" my-6">
                <label for="product_name" class="block font-medium text-gray-700">Books Name:</label>
                <input type="text" id="product_name" name="books_name" required
                    class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Quantity -->
            <div class=" my-6">
                <label for="quantity" class="block font-medium text-gray-700">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" required
                    class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400">
            </div>



            <label class="block mb-2 font-medium">Rating (1 to 5)</label>
            <select name="rating" required class="w-full px-4 py-2 border rounded mb-6">
                <option value="">Select rating</option>
                <option value="1">1 ⭐</option>
                <option value="2">2 ⭐⭐</option>
                <option value="3">3 ⭐⭐⭐</option>
                <option value="4">4 ⭐⭐⭐⭐</option>
                <option value="5">5 ⭐⭐⭐⭐⭐</option>
            </select>

            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded">
                Return Product
            </button>
        </form>

    </div>

    <!-- Post Section -->
    <div id="catagorypost" class="flex-1 p-6 md:p-9 hidden disabled:">
        <h1 class="text-3xl font-bold">BOOKS DETAILS</h1>
        
    <div  class=" bg-white mt-8 rounded-lg h-full overflow-hidden"
    >
    <!-- Product Image Section -->
    <div class="w-1/6 mt-7 items-center">
        <img id="detailImage" src="<?php echo htmlspecialchars($product['image']); ?>" 
            alt="<?php echo htmlspecialchars($product['books_name']); ?>" 
            class="w-full h-80 object-cover rounded-l-lg">
    </div>

    <!-- Product Information Section -->
    <div class="p-8 w-2/3">
        <h2 id="detailName" class="text-3xl font-extrabold text-gray-900 mb-4">
        <?php echo htmlspecialchars($product['books_name']); ?>
        </h2>
        <p id="detailWriter" class="text-xl font-semibold text-gray-800 mb-3">
        <strong>Writer:</strong> 
        <?php echo htmlspecialchars($product['writer_name']); ?>
        </p>
        <p id="detailDatePages" class="text-gray-600 mb-2">
            <strong >Published:</strong> <?php echo htmlspecialchars($product['publish_date']); ?>
             | <strong >Pages:</strong> <?php echo htmlspecialchars($product['page']); ?>
        </p>
        <p class="text-gray-600 mb-2">
            <strong>ISBN:</strong> 9780751565362 | <strong>ISBN10:</strong> 0751565369
        </p>

        <div class="mb-6">
            <p class="text-gray-700 text-lg mb-4">
                It has never been easy being Harry Potter, and it isn’t much easier now that he is an overworked employee of the Ministry of Magic, a husband, and a father of three school-age children...
            </p>
            <p class="text-gray-700 text-lg">
                Harry Potter is a man struggling to live up to the legacy of his past, and the mysterious dark force looming over him may be his greatest challenge yet.
            </p>
        </div>

        <div class="flex justify-between items-center">
            <div>
                <p id="detailPrice"  class="text-gray-800 font-semibold text-xl">Price: <span class="text-lg text-cyan-600"><?php echo htmlspecialchars($product['price']); ?> $</span></p>
            </div>
           <div class="cart-btn flex justify-between items-center gap-5">
           <button class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg text-lg focus:outline-none"
           onclick="activateItem(this);toggleCategoryDetails('orderbooks');">
                Order books
            </button>
            <button class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg text-lg focus:outline-none"
            onclick="activateItem(this);toggleCategoryDetails('returnbooks');">
                Return books
            </button>
           </div>
        </div>
    </div>
</div>

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

    <!-- collection Section -->
    <div id="catagorycollection" class="flex-1 p-6 md:p-9 hidden">
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
                <button type="submit" class="absolute right-4 top-4 text-3xl cursor-pointer text-gray-500">
                    <i class='bx bx-search-alt-2'></i>
                </button>
            </div>
        </form>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if (empty($collection)): ?>
            <p class="text-center text-gray-600 col-span-full">No products found.</p>
            <?php else: ?>
            <?php foreach ($collection as $product): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="flex items-center justify-center p-4">
                    <img src="<?php echo htmlspecialchars($product['image'] ?? 'default.jpg'); ?>"
                        alt="<?php echo htmlspecialchars($product['books_name'] ?? 'Unknown'); ?>"
                        class="h-48 w-36 object-cover">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <?php echo htmlspecialchars($product['books_name']?? 'No Name') ; ?>
                       
                    </h3>
                    <h1 class="text-lg font-semibold italic underline text-gray-800">
                        Order date :
                    <?php echo htmlspecialchars($product['borrow_date'])??'' ; ?>
                    </h1>
                    <p class="text-sm text-gray-600 mt-2">
                        <?php echo htmlspecialchars($product['description'] ?? ''); ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <script src="library-page.js">


        </script>
</body>

</html>