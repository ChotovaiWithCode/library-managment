<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: access_denied.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
        <!-- main containt -->
        <main class="w-full md:ml-20 pt-20 md:pt-6 px-4">
            <h1 class="text-3xl font-bold mb-6">My dashboard</h1>

            <?php
                // DB connection (replace with your actual credentials)
                include 'database.php';

                // Query to sum the total_quantity column
                $sql = "SELECT SUM(total_quantity) AS total_qty FROM bookscollection";
                $result = $conn->query($sql);

                $totalQuantity = 0;
                $borrowQuantity =0;
                if ($result && $row = $result->fetch_assoc()) {
                    $totalQuantity = $row['total_qty'] ?? 0;
                }

                $borrowedBooksSql = "SELECT SUM(borrow_count) AS total_borrowed FROM bookscollection";
                $borrowedBooksResult = $conn->query($borrowedBooksSql);
                $totalBorrowed = 0;
                if ($borrowedBooksResult && $row = $borrowedBooksResult->fetch_assoc()) {
                    $totalBorrowed = $row['total_borrowed'] ?? 0;
                }

                $overdueBooksSql = "SELECT SUM(overdue_count) AS total_overdue FROM bookscollection";
                $overdueBooksResult = $conn->query($overdueBooksSql);
                $totalOverdue = 0;
                if ($overdueBooksResult && $row = $overdueBooksResult->fetch_assoc()) {
                    $totalOverdue = $row['total_overdue'] ?? 0;
                }

                // Count users where loginrole is NOT 'admin'
                $sql = "SELECT COUNT(*) AS user_count FROM logininfo WHERE loginrole != 'admin'";
                $result = $conn->query($sql);

                $nonAdminUsers = 0;
                if ($result && $row = $result->fetch_assoc()) {
                    $nonAdminUsers = $row['user_count'] ?? 0;
}

               

                
                ?>


            <!-- Stats cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="font-bold">Total book</p>
                    <p class="text-3xl font-bold"><?php echo number_format($totalQuantity); ?></p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-orange-500 font-bold">Borrowed book</p>
                    <p class="text-3xl font-bold text-orange-600"><?php echo number_format($totalBorrowed); ?></p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="font-bold">Overdue</p>
                    <p class="text-3xl font-bold"><?php echo number_format($totalOverdue); ?></p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-orange-500 font-bold">Members</p>
                    <p class="text-3xl font-bold text-orange-600"><?php echo number_format($nonAdminUsers); ?></p>
                </div>
            </div>

            <!-- Rental rate charts -->
            <p class="text-xl font-bold mb-4">Rental rate</p>
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="bg-white w-full lg:w-3/5 rounded-xl shadow p-4">
                    <canvas id="rentalChart" class="w-full h-64"></canvas>
                </div>
                <div class="w-full lg:w-1/4  p-4">
                    <div class="flex items-center gap-4">

                        <?php
                    
                        // All books: sum of total_quantity
                        $allBooks = 0;
                        $allBooksSql = "SELECT SUM(total_quantity) AS total FROM bookscollection";
                        $result = $conn->query($allBooksSql);
                        if ($result && $row = $result->fetch_assoc()) {
                            $allBooks = (int)$row['total'];
                        }

                        // New books: sum of available_quantity
                        $newBooks = 0;
                        $newBooksSql = "SELECT SUM(available_quantity) AS total FROM bookscollection";
                        $result = $conn->query($newBooksSql);
                        if ($result && $row = $result->fetch_assoc()) {
                            $newBooks = (int)$row['total'];
                        }

                        // Damage books: sum of return_count from admin_info
                        $damageBooks = 0;
                        $damageSql = "SELECT SUM(return_count) AS total FROM admin_info";
                        $result = $conn->query($damageSql);
                        if ($result && $row = $result->fetch_assoc()) {
                            $damageBooks = (int)$row['total'];
                        }

                       

                        // Optional: Prevent division by zero
                        $total = $allBooks + $newBooks + $damageBooks;
                        if ($total == 0) $total = 1;

                        // Percentages (for display or tooltip)
                        $allBooksPercent = round(($allBooks / $total) * 100, 1);
                        $newBooksPercent = round(($newBooks / $total) * 100, 1);
                        $damageBooksPercent = round(($damageBooks / $total) * 100, 1);

                        
                        ?>

                        <canvas id="pieChart" class="w-6 h-6"></canvas>
                        <div>
                            <p class="flex w-[200px] items-center gap-2">
                                <span class="w-3 h-3 bg-blue-900 rounded-full"></span> All books
                            </p>
                            <p class="flex w-[200px] items-center gap-2">
                                <span class="w-3 h-3 bg-orange-600 rounded-full"></span> New books
                            </p>
                            <p class="flex w-[200px] items-center gap-2">
                                <span class="w-3 h-3 bg-pink-300 rounded-full"></span> Damage books
                            </p>
                        </div>
                    </div>
                    <!-- <div class="mt-6">
                        <p class="text-xl font-semibold mb-4 ml-4">KPIs</p>
                        <div class="flex justify-around">
                            <div class="text-center">
                                <p class="text-sm text-blue-600">Borrowed</p>
                                <p class="text-2xl font-bold">53%</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-orange-600">Returned</p>
                                <p class="text-2xl font-bold">90%</p>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- Borrow rate and restricted members -->
            <p class="text-xl font-bold mt-8 mb-4">Borrow rate</p>
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full lg:w-2/3 bg-white p-4 rounded-xl shadow">

                    <?php
                    // Get total borrow count
                        $totalSql = "SELECT SUM(borrow_count) AS total FROM bookscollection";
                        $totalResult = $conn->query($totalSql);
                        $totalBorrow = 1; // Prevent division by zero
                        if ($totalResult && $row = $totalResult->fetch_assoc()) {
                            $totalBorrow = (int)$row['total'] ?: 1;
                        }

                        // Get borrow count per category
                        $categorySql = "SELECT category, SUM(borrow_count) AS borrow FROM bookscollection GROUP BY category";
                        $categoryResult = $conn->query($categorySql);

                        // Prepare data for Chart.js
                        $categories = [];
                        $percentages = [];

                        if ($categoryResult) {
                            while ($row = $categoryResult->fetch_assoc()) {
                                $categories[] = $row['category'];
                                $percentages[] = round(($row['borrow'] / $totalBorrow) * 100, 1); // As percentage
                            }
                        }

                    ?>

                    <canvas id="barChart" class="w-full h-48"></canvas>
                </div>
                <div class="w-full lg:w-1/3 bg-white p-4 rounded-xl shadow">
                    <h2 class="text-lg font-bold mb-4">Restricted members</h2>
                    <table class="w-full text-sm text-center">
                        <thead class="text-gray-500 border-b">
                            <tr>
                                <th class="py-2">Member ID</th>
                                <th class="py-2">Member name</th>
                            </tr>
                        </thead>
                        <?php
                    $query = "SELECT member_id, member_name FROM restricted_user";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<tr class="border-b">';
                                echo '<td class="py-2">' . htmlspecialchars($row['member_id']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['member_name']) . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="2" class="text-center py-2 text-gray-500">No restricted users found.</td></tr>';
                        }
                    ?>
                    </table>
                </div>
            </div>

            <!-- Borrowed History -->
            <div class="mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Recent borrowed history</h2>

                    <select class="border rounded p-1 text-sm">
                        <option>Latest</option>
                        </select>
                </div>
                <div class="overflow-auto bg-white rounded-xl shadow">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-blue-900 text-white">
                            <tr>
                                <th class="p-2">Book ID</th>
                                <th class="p-2">Title</th>
                                <th class="p-2">Name</th>
                                <th class="p-2">Borrowed date</th>
                                <th class="p-2">Status</th>
                                <th class="p-2">Actions</th>
                            </tr>
                        </thead>
                        <form id="deleteForm" action="delete_borrow.php" method="POST" style="display:none;">
                            <input type="hidden" name="id" id="deleteId">
                        </form>

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

                        <?php
                        // Assuming $conn is your active mysqli connection

                        $query = "SELECT
                            id,
                            book_id,
                            title,
                            user_name,
                            borrow_date,
                            status
                        FROM borrow_history
                        ORDER BY borrow_date DESC";  // newest first

                        $result = $conn->query($query);

                        if ($result && $result->num_rows > 0) {
                            echo '<tbody>';
                            while ($row = $result->fetch_assoc()) {
                                // Set status classes based on status value
                                $statusClass = '';
                                if ($row['status'] === 'returned') {
                                    $statusClass = 'bg-green-100 text-green-600';
                                } elseif ($row['status'] === 'overdue') {
                                    $statusClass = 'bg-red-100 text-red-600';
                                } else {
                                    // borrowed
                                    $statusClass = 'bg-yellow-100 text-yellow-600';
                                }

                                echo '<tr class="border-b">';
                                echo '<td class="p-2">#' . htmlspecialchars($row['id']) . '</td>';
                                echo '<td class="p-2">' . htmlspecialchars($row['title']) . '</td>';
                                echo '<td class="p-2 flex items-center gap-2">
                                        <img src="https://i.pravatar.cc/20?u=' . urlencode($row['user_name']) . '" class="rounded-full w-5 h-5" alt="avatar">
                                        ' . htmlspecialchars($row['user_name']) . '
                                    </td>';
                                echo '<td class="p-2">' . date('F j, Y', strtotime($row['borrow_date'])) . '</td>';
                                echo '<td class="p-2"><span class="' . $statusClass . ' px-2 py-1 rounded-full text-xs">' . htmlspecialchars($row['status']) . '</span></td>';
                                echo '<td class="p-2 gap-3">';
                                    echo '<span class="bx bx-edit cursor-pointer text-lg"></span> ';  // icons example, class quoted
                                    echo '<span 
                                        class="bx bx-trash cursor-pointer text-lg text-red-600" 
                                        onclick="confirmDelete(\'' . $row['book_id'] . '\')" 
                                        title="Delete">
                                        </span>';


                                  
                                        echo '<span 
                                            class="bx bx-dots-horizontal-rounded text-lg text-yellow-600 cursor-pointer" 
                                            onclick="openRestrictModal(' . htmlspecialchars(json_encode($row['id'])) . ', \'' . htmlspecialchars($row['user_name'], ENT_QUOTES) . '\')">
                                        </span>';
                                    


                                 '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                        } else {
                            echo '<tbody><tr><td colspan="6" class="p-4 text-center">No records found.</td></tr></tbody>';
                        }
                        ?>
                        <!-- pupup -->
                        <div id="restrictModal"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md animate-fadeIn">
                                <h2 class="text-xl font-semibold mb-4">Restrict User</h2>
                                <p id="restrictMessage" class="mb-6">Do you want to restrict this user?</p>
                                <div class="flex justify-end gap-2">
                                    <form id="blockForm" method="POST" action="restrict_user.php">
                                        <input type="hidden" name="action" value="block">
                                        <input type="hidden" name="member_id" id="blockMemberId">
                                        <input type="hidden" name="member_name" id="blockMemberName">
                                        <button type="submit"
                                            class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700">Block</button>
                                    </form>
                                    <form id="unblockForm" method="POST" action="restrict_user.php">
                                        <input type="hidden" name="action" value="unblock">
                                        <input type="hidden" name="member_id" id="unblockMemberId">
                                        <button type="submit"
                                            class="bg-gray-300 px-5 py-2 rounded hover:bg-gray-400">Unblock</button>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Rental Chart
    new Chart(document.getElementById('rentalChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                    label: 'Borrowed rate',
                    data: [300, 500, 450, 400, 200, 150, 250, 300, 450, 500, 470, 420],
                    borderColor: '#1E3A8A',
                    fill: false,
                    tension: 0.4
                },
                {
                    label: 'User conversion',
                    data: [100, 250, 400, 500, 300, 200, 220, 310, 390, 370, 360, 300],
                    borderColor: '#EA580C',
                    fill: false,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true
        }
    });

    // Pie Chart
    const ctx = document.getElementById('pieChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {

            datasets: [{
                data: [
                    <?php echo $allBooks; ?>,
                    <?php echo $newBooks; ?>,
                    <?php echo $damageBooks; ?>
                ],
                backgroundColor: ['#1E3A8A', '#EA580C', '#F9A8D4']
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.parsed;
                            let total = <?php echo $allBooks + $newBooks + $damageBooks; ?>;
                            let percentage = total ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Bar Chart
    const categories = <?php echo json_encode($categories); ?>;
    const percentages = <?php echo json_encode($percentages); ?>;

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: categories,
            datasets: [{
                label: 'Borrowed %',
                data: percentages,
                backgroundColor: [
                    '#a5b4fc', '#fcd34d', '#f87171', '#fbbf24',
                    '#a78bfa', '#d9f99d', '#fcd9b0', '#fda4af', '#93c5fd'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.parsed.y + '%'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: val => val + '%'
                    }
                }
            }
        }
    });

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
    // pupuphandel
    function openRestrictModal(memberId, memberName) {
        document.getElementById('restrictModal').classList.remove('hidden');
        document.getElementById('blockMemberId').value = memberId;
        document.getElementById('unblockMemberId').value = memberId;
        document.getElementById('blockMemberName').value = memberName;
        document.getElementById('restrictMessage').innerText = `Do you want to restrict ${memberName}?`;
    }

    // Optional: close modal on Escape key or click outside
    window.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.getElementById('restrictModal').classList.add('hidden');
    });
    // deleterecord
    let deleteBookId = null;

  function confirmDelete(id) {
    deleteBookId = id;
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