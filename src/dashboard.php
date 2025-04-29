<?php
echo'
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
            <?php if (empty($products)): ?>
            <p class="text-center text-gray-600 col-span-full">No products found.</p>
            <?php else: ?>
            <?php foreach ($products as $product): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
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

'
?>