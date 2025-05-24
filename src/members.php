<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['add_member'])) {
        // your POST data
        $name = $_POST['name'];
        $place = $_POST['place'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $membership_date = $_POST['membership_date'];
        $remark = $_POST['remark'];

        // Check if email exists in logininfo
        $checkEmail = $conn->prepare("SELECT email FROM logininfo WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $result = $checkEmail->get_result();

        if ($result->num_rows > 0) {
            // Check if email already used in member_info
            $checkMember = $conn->prepare("SELECT email FROM member_info WHERE email = ?");
            $checkMember->bind_param("s", $email);
            $checkMember->execute();
            $memberResult = $checkMember->get_result();

            if ($memberResult->num_rows > 0) {
             echo "<script>
                    alert('Email is already used for a member.');
                    window.location.href = 'members.php';
                </script>";
                exit;
            } else {
               // Generate a random member_id
                  $member_id = "MEM" . date("Ymd") . rand(1000, 9999);

                  // Prepare insert query
                  $stmt = $conn->prepare("INSERT INTO member_info (member_id, name, place, phone, address, email, membership_date, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                  $stmt->bind_param("ssssssss", $member_id, $name, $place, $phone, $address, $email, $membership_date, $remark);

                  // Execute insert
                  if ($stmt->execute()) {
                     
                      echo "<script>alert('Member added successfully.');</script>";
                  } else {
                      echo "<script>alert('Failed to add member: " . $stmt->error . "');</script>";
                  }
            }
        } else {
            echo "<script>alert('Email doesn\\'t match any registered login info.');</script>";
            

            header('members.php');
            
        }
    } elseif (isset($_POST['cancel'])) {
        echo "<script>window.location.href='members.php';</script>";
        exit;
    }

} 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: access_denied.php");
    exit();
}

// get number for display member_id
$memberName = isset($_GET['memberName']) ? $conn->real_escape_string($_GET['memberName']) : '';


$memberId = '';

if ($memberName !== '') {
    // Query the member_info table for the member ID
    $sql = "SELECT member_id FROM member_info WHERE name = '$memberName' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $memberId = $row['member_id'];
    }
}


?>
<?php
//display all member
$query = "SELECT member_id, name, status FROM member_info";
$result = $conn->query($query);
?>
<?php
//email set from logininfo

$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Member Dashboard</title>
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


        <!-- Main content wrapper (add left margin to avoid overlap with fixed sidebar) -->
        <div class="flex-1 md:ml-20">

            <div class="flex flex-col md:flex-row md:items-center md:justify-center gap-4 p-4 md:ml-20">


                <?php
                $selectedStatus = $_GET['status'] ?? 'All';
                ?>


                <!-- Option Dropdown -->
                <div class="flex items-center gap-2">
                    <form method="GET" action="members.php">
                        <div class="flex items-center gap-2">
                            <select id="option" name="status" class="border p-2 rounded" onchange="this.form.submit()">
                                <option value="All" <?= $selectedStatus === 'All' ? 'selected' : '' ?>>All</option>
                                <option value="New" <?= $selectedStatus === 'New' ? 'selected' : '' ?>>New Members
                                </option>
                                <option value="Active" <?= $selectedStatus === 'Active' ? 'selected' : '' ?>>Active
                                </option>
                                <option value="Inactive" <?= $selectedStatus === 'Inactive' ? 'selected' : '' ?>>
                                    Inactive</option>
                            </select>
                        </div>
                    </form>


                </div>

                <!-- Member ID -->
                <form method="GET" action="members.php" class="flex gap-2">
                    <div class="flex items-center gap-2">
                        <label for="memberId" class="text-sm font-medium">Member ID:</label>
                        <input id="memberId" name="memberId" type="text" class="border p-2 rounded"
                            placeholder="e.g. 123456" value="<?php echo htmlspecialchars($memberId); ?>" readonly>
                    </div>

                    <div class="flex items-center gap-2">
                        <label for="memberName" class="text-sm font-medium">Name:</label>
                        <input id="memberName" name="memberName" type="text" class="border p-2 rounded"
                            placeholder="e.g. Julia" value="<?php echo htmlspecialchars($memberName); ?>">
                    </div>

                    <button type="submit" class="bg-blue-900 text-white px-4 sm:px-4 py-2 rounded hover:bg-blue-800">
                        Search
                    </button>
                </form>
            </div>

        </div>
    </div>
    <!-- Main Content -->
    <div class="flex flex-col lg:flex-row flex-1 md:ml-20">



        <!-- Member List -->
        <div class=" sm:w-2/3 md:w-3/3 flex-1 p-4 mt-6">

            <h2 class="text-2xl font-bold mb-4">All members</h2>
            <div class="overflow-x-auto overflow-y-auto h-[80vh]">

                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-blue-900 text-white">
                        <tr class="text-xl text-left">
                            <th class="px-3 py-2 border">Member ID</th>
                            <th class="px-3 py-2 border">Name</th>
                            <th class="px-3 py-2 border">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="memberTableBody">
                        <?php if ($result->num_rows > 0): ?>
                        <?php
        $rowIndex = 0;
        while ($row = $result->fetch_assoc()):
            $rowIndex++;
            $statusClass = match ($row['status']) {
                'active' => 'bg-green-100 text-green-600',
                'inactive' => 'bg-red-100 text-red-600',
                default => 'bg-gray-100 text-gray-600',
            };
            $displayClass = ($rowIndex > 3) ? 'hidden extra-row' : ''; 
        ?>
                        <tr class="border-b <?php echo $displayClass; ?>">
                            <td class="px-3 py-2 border"><?php echo htmlspecialchars($row['member_id']); ?></td>
                            <td class="px-3 py-2 border"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td class="px-3 py-2 border <?php echo $statusClass; ?>">
                                <?php echo htmlspecialchars($row['status']); ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-3 text-gray-500">No members found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>

                    <tbody>
                        <tr id="seeMoreRow" class="bg-white">
                            <td colspan="3" class="text-center py-4">
                                <button id="toggleRowsBtn"
                                    class="px-4 py-2 bg-blue-900 text-white rounded flex items-center gap-2 mx-auto"
                                    onclick="toggleRows()">
                                    See more
                                    <i class='bx bx-right-arrow-alt'></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>


        <!-- Member Form -->
        <div class="flex-1 p-6 mt-6">
            <div class="flex justify-between">
                <h2 class="text-2xl font-bold mb-4">Member latest record</h2>

            </div>

            <!-- Upload Area -->
            <form id="membershipForm" class="p-6 w-full max-w-4xl space-y-4" method="POST" action="add_member.php"
                enctype="multipart/form-data">

                <!-- Image Upload -->
                <div
                    class="relative w-48 h-48 border-dashed border-2 border-gray-300 rounded-full flex items-center justify-center text-center mx-auto mb-6 overflow-hidden">
                    <img id="preview" class="absolute inset-0 w-full h-full object-cover rounded-full hidden"
                        alt="Preview" />
                    <input type="file" name="upload_file" accept="image/*"
                        class="absolute inset-0 opacity-0 cursor-pointer z-10" required onchange="previewImage(event)">
                    <p id="placeholder" class="text-gray-500 text-sm pointer-events-none z-0">
                        Drop files to upload<br><span class="text-blue-500 underline">or browse</span>
                    </p>
                </div>

                <!-- Fields -->
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium w-40">Name:</label>
                    <input type="text" name="name" class="border p-2 rounded w-full" placeholder="Enter your name"
                        required>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium w-40">Place:</label>
                    <input type="text" name="place" class="border p-2 rounded w-full" placeholder="Enter your place"
                        required>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium w-40">Phone:</label>
                    <input type="text" name="phone" class="border p-2 rounded w-full" placeholder="Enter your phone"
                        required>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium w-40">Address:</label>
                    <input type="text" name="address" class="border p-2 rounded w-full" placeholder="Enter your address"
                        required>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium w-40">Email:</label>
                    <?php $email = $_SESSION['email'] ?? ''; ?>
                    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>"
                        class="border p-2 rounded w-full bg-gray-100" readonly>


                </div>


                <!-- Membership Logic -->
                <div class="flex items-center gap-4">
                    <div class="w-1/2">
                        <label class="block text-sm font-medium mb-1">Membership Duration (Months):</label>
                        <input type="number" id="quantity" name="quantity" class="border p-2 rounded w-full"
                            placeholder="e.g. 5" min="0" oninput="calculateResult()" required>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-sm font-medium mb-1">Membership Price ($):</label>
                        <input type="text" id="result" name="price" class="border p-2 rounded w-full bg-gray-100"
                            readonly>
                    </div>
                </div>


                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium w-40">Remark:</label>
                    <textarea name="remark" class="border p-2 rounded w-full" placeholder="Any remarks..."></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" onclick="showConfirmationModal()"
                        class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800">
                        Add
                    </button>

                    <button type="button" name="cancel"
                        class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</button>
                </div>
            </form>

            <!-- Membership Modal -->

            <div id="confirmationModal"
                class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded shadow-md w-full max-w-md text-center">
                    <p class="text-lg font-semibold mb-4">Welcome to our membership!</p>
                    <p class="mb-4 text-gray-700" id="confirmationMessage">
                        Your membership date is <strong id="confirmQuantity">X</strong>month and your membership price
                        is
                        <strong id="confirmPrice">$Y</strong>.<br>
                        Do you confirm this condition?
                    </p>
                    <div class="flex justify-center gap-4">
                        <button onclick="submitForm()"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Yes</button>
                        <button onclick="closeModal()"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">No</button>
                    </div>
                </div>
            </div>



            <!--BROWSE HISTORY -->
            <div class=" sm:w-3/3 md:w-3/3 flex-1 p-2 mt-6">

                <div class="flex justify-between">
                    <h2 class="text-2xl font-bold mb-4">Borrowed history</h2>
                    <!-- Option Dropdown -->
                    <div class="flex items-center">
                        <select id="option" class="border ">
                            <option>Today</option>
                        </select>
                    </div>
                </div>
                <div class="overflow-x-auto overflow-y-auto h-[80vh]">

                    <table class="w-full text-md rounded-t-lg">
                        <thead class="bg-blue-900 text-white">
                            <tr class="text-left">
                                <th class="px-3">Book ID</th>
                                <th class="px-3">Name</th>
                                <th class="px-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Repeatable row -->
                            <tr class="border-t bg-white border-r">
                                <td>#154784</td>
                                <td class="flex items-center space-x-2 py-1">
                                    <img src="https://via.placeholder.com/24" class="rounded-full w-6 h-6"
                                        alt="profile">
                                    <span>Julia</span>
                                </td>
                                <td><span class="text-green-500">new member</span></td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>

                </form>
            </div>
        </div>
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
    // for see member
    let expanded = false;

    function toggleRows() {
        const extraRows = document.querySelectorAll('.extra-row');
        const toggleBtn = document.getElementById('toggleRowsBtn');

        extraRows.forEach((row, index) => {
            if (expanded) {
                row.classList.add('hidden');
            } else {
                if (index < 2) row.classList.remove('hidden'); // show 2 more (rows 4 and 5)
            }
        });

        toggleBtn.innerHTML = expanded ?
            `See more <i class='bx bx-right-arrow-alt'></i>` :
            `See less <i class='bx bx-left-arrow-alt'></i>`;

        expanded = !expanded;
    }

    //IMAGE PREVIEW
    // function previewImage(event) {
    //     const reader = new FileReader();
    //     reader.onload = function() {
    //         const preview = document.getElementById('preview');
    //         preview.src = reader.result;
    //         preview.classList.remove('hidden');
    //         document.getElementById('placeholder').classList.add('hidden');
    //     };
    //     reader.readAsDataURL(event.target.files[0]);
    // }

    function showConfirmationModal() {

        const quantity = document.getElementById("quantity").value;
        const price = document.getElementById("result").value;

        document.getElementById("confirmQuantity").textContent = quantity;
        document.getElementById("confirmPrice").textContent = `$${price}`;

        document.getElementById("confirmationModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("confirmationModal").classList.add("hidden");
    }

    function submitForm() {
        document.getElementById("membershipForm").submit();
    }

    function closeModal() {
        document.getElementById("confirmationModal").classList.remove("flex");
        document.getElementById("confirmationModal").classList.add("hidden");
    }

    function submitForm() {
        closeModal();
        document.getElementById("membershipForm").submit();
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('preview');
            output.src = reader.result;
            output.classList.remove("hidden");
            document.getElementById('placeholder').classList.add("hidden");
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function calculateResult() {
        const quantity = parseInt(document.getElementById("quantity").value, 10);
        const pricePerMonth = 10; // Example rate
        const result = isNaN(quantity) ? '' : `$${quantity * pricePerMonth}`;
        document.getElementById("result").value = result;
    }
    </script>
</body>

</html>