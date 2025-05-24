<?php
session_start();

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $book) {
?>
<div class="bg-white p-4 rounded-lg shadow-md mb-4 flex gap-4 items-start">
    <img src="<?php echo htmlspecialchars($book['image_url']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" class="w-20 h-28 object-cover rounded-md">
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
            <p>Membership time: 6 months</p>
            <p>Borrowed by: Allison</p> <!-- Dummy placeholder -->
            <p>Member ID: 38572</p>     <!-- Dummy placeholder -->
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
