<h1>Login</h1>

<?php if (isset($error)): ?>
<p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form id="login" method="post" action="/login">
    <label for="email_or_username">Email or username:</label><br>
    <input id="email_or_username" type="text" name="email_or_username" value="<?= htmlspecialchars($email_or_username ?? null) ?>" required><br><br>

    <label for="password">Password:</label><br>
    <input id="password" type="password" name="password" required><br><br>

    <input id="remember" type="checkbox" name="remember"> <label for="remember">Remember me</label><br><br> <!-- Will be added soon -->

    <input type="submit" value="Log In">
</form>

<p>Don’t have an account? <a href="/signup" data-internal>Sign up here</a>.</p>