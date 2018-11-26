<nav>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/calendar">Calendar</a></li>
        <li><a href="/recipe?name=meatballs">Meatballs recipe</a></li>
        <li><a href="/recipe?name=pancakes">Pancakes recipe</a></li>
        <?php if ($current_user): ?>
        <li>
            <form action="/logout" method="post">
                <input type="submit" value="Logout (<?= $current_user->getName() ?>)"/>
            </form>
        </li>
        <?php else: ?>
        <li><a href="/login">Login</a></li>
        <?php endif ?>
    </ul>
</nav>
