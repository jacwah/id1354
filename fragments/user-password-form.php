<form action="<?= $action ?>" method="post" class="user-password">
    <div class="inputgroup">
        <label for="username">Username</label>
        <input type="text" name="username" required/>
    </div>
    <div class="inputgroup">
        <label for="password">Password</label>
        <input type="password" name="password" required/>
    </div>
    <div class="inputgroup">
        <input type="submit" value="<?= $submit ?>"/>
    </div>
</form>
