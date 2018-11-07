<nav>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/calendar.php">Calendar</a></li>
        <li><a href="/recipe.php?name=meatballs">Meatballs recipe</a></li>
        <li><a href="/recipe.php?name=pancakes">Pancakes recipe</a></li>
        <?php if ($_SESSION['username']): ?>
        <li><a href="/logout.php">Logout (<?php echo $_SESSION['username']?>)</a></li>
        <?php else: ?>
        <li><a href="/login.php">Login</a></li>
        <?php endif ?>
    </ul>
</nav>
