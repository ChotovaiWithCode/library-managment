<?php
include 'database.php'; // Make sure $conn is set

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['member_id'])) {
    $member_id = intval($_POST['member_id']);
    $action = $_POST['action'];

    if ($action === 'block' && isset($_POST['member_name'])) {
        $member_name = trim($_POST['member_name']);

        // Avoid duplicate restriction
        $check = $conn->prepare("SELECT id FROM restricted_user WHERE member_id = ?");
        $check->bind_param("i", $member_id);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO restricted_user (member_id, member_name) VALUES (?, ?)");
            $stmt->bind_param("is", $member_id, $member_name);
            $stmt->execute();
        }

    } elseif ($action === 'unblock') {
        $stmt = $conn->prepare("DELETE FROM restricted_user WHERE member_id = ?");
        $stmt->bind_param("i", $member_id);
        $stmt->execute();
    }
}

header("Location: my_dashboard.php?msg=restrict_updated");
exit;
?>
