<nav>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/calendar">Calendar</a></li>
        <li><a href="/recipe?name=meatballs">Meatballs recipe</a></li>
        <li><a href="/recipe?name=pancakes">Pancakes recipe</a></li>
        <li id="logout" class="logged-in">
            <button id="logout-button"></button>
        </li>
        <li id="login" class="logged-out">
            <form id="login-form">
                <label for="username">Username</label>
                <input type="text" name="username"/>
                <label for="password">Password</label>
                <input type="password" name="password"/>
                <input type="submit" value="Login"/>
            </form>
        </li>
    </ul>
</nav>
