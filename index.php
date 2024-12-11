<?php if (isset($_SESSION["unique_id"])): ?>
            <a href="logout.php" class="btn btn-primary">Logout</a>
        <?php else: ?>
            <a href="registration.html" class="btn btn-primary">Login / Sign Up</a>
        <?php endif; ?>