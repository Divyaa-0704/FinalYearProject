<?php session_start(); ?>
<h2>Welcome Admin, <?php echo $_SESSION['username']; ?>!</h2>
<a href="logout.php">Logout</a>
