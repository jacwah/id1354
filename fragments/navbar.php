<nav>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/calendar">Calendar</a></li>
        <li><a href="/recipe?name=meatballs">Meatballs recipe</a></li>
        <li><a href="/recipe?name=pancakes">Pancakes recipe</a></li>
        <?php if ($user_cntr): ?>
        <li>
            <form action="/logout" method="post">
                <input type="submit" value="Logout (<?= $user_cntr->getUser()->getName() ?>)"/>
            </form>
        </li>
        <?php else: ?>
        <li><a href="/login">Login</a></li>
        <?php endif ?>
    </ul>
</nav>
