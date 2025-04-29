<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Sidebar -->
  <div class="flex">
    <aside class="w-64 bg-white shadow-md h-screen p-5">
      <div class="text-2xl font-bold text-blue-600 mb-10">
        Admin Panel
      </div>
      <nav class="flex flex-col gap-6 text-gray-700">
        <a href="#" class="hover:text-blue-600">Dashboard</a>
        <a href="#" class="hover:text-blue-600">Products</a>
        <a href="#" class="hover:text-blue-600">Transactions</a>
        <a href="#" class="hover:text-blue-600">Reports</a>
        <a href="#" class="hover:text-blue-600">Settings</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Welcome Back!</h1>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Sign Out</button>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition">
          <h2 class="text-gray-600 text-sm mb-2">Total Products</h2>
          <p class="text-2xl font-bold text-gray-800">120</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition">
          <h2 class="text-gray-600 text-sm mb-2">Registered Users</h2>
          <p class="text-2xl font-bold text-gray-800">45</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition">
          <h2 class="text-gray-600 text-sm mb-2">Books Borrowed</h2>
          <p class="text-2xl font-bold text-gray-800">18</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition">
          <h2 class="text-gray-600 text-sm mb-2">Late Returns</h2>
          <p class="text-2xl font-bold text-gray-800">5</p>
        </div>
      </div>

      <!-- Table -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Recent Transactions</h2>
        <div class="overflow-x-auto">
          <table class="w-full text-left text-gray-700">
            <thead>
              <tr class="bg-gray-100">
                <th class="p-3">#</th>
                <th class="p-3">User</th>
                <th class="p-3">Book</th>
                <th class="p-3">Date Borrowed</th>
                <th class="p-3">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b hover:bg-gray-50">
                <td class="p-3">1</td>
                <td class="p-3">John Doe</td>
                <td class="p-3">Atomic Habits</td>
                <td class="p-3">2025-04-25</td>
                <td class="p-3"><span class="text-green-500 font-semibold">Returned</span></td>
              </tr>
              <tr class="border-b hover:bg-gray-50">
                <td class="p-3">2</td>
                <td class="p-3">Jane Smith</td>
                <td class="p-3">The Alchemist</td>
                <td class="p-3">2025-04-26</td>
                <td class="p-3"><span class="text-yellow-500 font-semibold">Pending</span></td>
              </tr>
              <tr class="border-b hover:bg-gray-50">
                <td class="p-3">3</td>
                <td class="p-3">Mark Lee</td>
                <td class="p-3">Rich Dad Poor Dad</td>
                <td class="p-3">2025-04-27</td>
                <td class="p-3"><span class="text-red-500 font-semibold">Overdue</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </main>
  </div>

</body>
</html>
