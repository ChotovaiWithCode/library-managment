<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Items - Library</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg">
      <div class="p-6 text-2xl font-bold">SAPIENS</div>
      <nav class="mt-10">
        <ul class="space-y-2">
          <li><a href="#" class="block py-2.5 px-4 hover:bg-gray-200">Library</a></li>
          <li><a href="#" class="block py-2.5 px-4 bg-blue-100 text-blue-700 font-semibold">Add Items</a></li>
          <li><a href="#" class="block py-2.5 px-4 hover:bg-gray-200">Add Collection</a></li>
          <li><a href="#" class="block py-2.5 px-4 hover:bg-gray-200">Publish</a></li>
          <li><a href="#" class="block py-2.5 px-4 hover:bg-gray-200">Dashboard</a></li>
          <li><a href="#" class="block py-2.5 px-4 hover:bg-gray-200">Settings</a></li>
          <li><a href="#" class="block py-2.5 px-4 hover:bg-gray-200">Support</a></li>
          <li><a href="#" class="block py-2.5 px-4 hover:bg-gray-200">Logout</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-10">
      <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold mb-8">Add Items</h1>
        <div class="flex items-center gap-2">
          <span>User</span>
          <div class="w-8 h-8 bg-cyan-400 rounded-full"></div>
        </div>
      </div>

      <!-- Top Tabs -->
      <div class="mb-6">
        <nav class="flex space-x-6 text-lg font-semibold">
          <a href="#" class="text-blue-600 border-b-2 border-blue-600 pb-2">Search</a>
          <a href="#" class="text-gray-400 pb-2">Manual Entry</a>
          <a href="#" class="text-gray-400 pb-2">Import CSV</a>
        </nav>
      </div>

      <!-- Select Collection -->
      <div class="bg-white p-6 rounded shadow-md space-y-6">
        <div>
          <label class="block text-gray-700 font-semibold mb-2">Select Collection</label>
          <select class="w-full border-gray-300 rounded-lg">
            <option>Harry Potter Collection</option>
          </select>
          <p class="text-gray-500 text-sm mt-1">Choose the collection you are adding items to.</p>
        </div>

        <!-- Select Item Type -->
        <div>
          <label class="block text-gray-700 font-semibold mb-2">Select Item Type</label>
          <div class="flex items-center space-x-6">
            <label class="flex items-center space-x-2">
              <input type="radio" name="type" checked>
              <span>Book</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="radio" name="type">
              <span>Movie</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="radio" name="type">
              <span>Music</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="radio" name="type">
              <span>Video Game</span>
            </label>
          </div>
          <p class="text-gray-500 text-sm mt-1">The type of item you are adding.</p>
        </div>

        <!-- Search -->
        <div>
          <label class="block text-gray-700 font-semibold mb-2">Search for Books</label>
          <div class="flex">
            <input type="text" placeholder="Harry Potter and The Cursed Child" class="flex-1 border border-gray-300 rounded-l-lg p-2">
            <button class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 rounded-r-lg">Search</button>
          </div>
          <p class="text-gray-500 text-sm mt-1">Search by ISBN or keyword. ISBN search will automatically add an item.</p>
        </div>
      </div>

      <!-- Book Result -->
      <div class="flex bg-white mt-8 rounded shadow-md overflow-hidden">
        <img src="https://images-na.ssl-images-amazon.com/images/I/51N9aPa2DLL._SX331_BO1,204,203,200_.jpg" alt="Harry Potter" class="w-48 object-cover">
        <div class="p-6">
          <h2 class="text-2xl font-bold mb-2">HARRY POTTER AND THE CURSED CHILD</h2>
          <p class="text-gray-700 font-semibold mb-2">J. K. Rowling, Jack Thorne, John Tiffany</p>
          <p class="text-gray-600 mb-2">2017 | Pages: 352</p>
          <p class="text-gray-600 mb-4">ISBN: 9780751565362 ISBN10: 0751565369</p>
          <p class="text-gray-600 text-sm mb-4">
            It has never been easy being Harry Potter, and it isn’t much easier now that he is an overworked employee of the Ministry of Magic, a husband, and a father of three school-age
        </p>
          <button class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-lg">Adicionar Item</button>
        </div>
      </div>

    </main>
  </div>
</body>
</html>