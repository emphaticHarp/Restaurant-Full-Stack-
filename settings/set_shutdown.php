<?php
// Start the session
session_start();

// Set the shutdown flag via AJAX
if (isset($_POST['action']) && $_POST['action'] == 'shutdown') {
    $_SESSION['shutdown'] = true;
    echo 'Shutdown flag set.';
}
?>
