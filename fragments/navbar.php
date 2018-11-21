<nav>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/calendar.php">Calendar</a></li>
        <li><a href="/recipe.php?name=meatballs">Meatballs recipe</a></li>
        <li><a href="/recipe.php?name=pancakes">Pancakes recipe</a></li>
        <?php if ($user_cntr): ?>
        <li>
            <form action="/logout.php" method="post">
                <input type="submit" value="Logout (<?= $user_cntr->getUser()->getName() ?>)"/>
            </form>
        </li>
        <?php else: ?>
        <li><a href="/login.php">Login</a></li>
        <?php endif ?>
    </ul>
</nav>
