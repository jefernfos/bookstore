<h1>Sign Up</h1>

<?php if (isset($error)): ?>
<p class="error"><?= $html($error) ?></p>
<?php endif; ?>

<form method="post" action="/signup">
    <label for="name">Full Name:</label><br>
    <input id="name" type="text" name="name" value="<?= $html($name ?? null) ?>" required><br><br>
    
    <label for="username">Username:</label><br>
    <input id="username" type="text" name="username" value="<?= $html($username ?? null) ?>" required><br><br>
    
    <label for="email">Email:</label><br>
    <input id="email" type="email" name="email" value="<?= $html($email ?? null) ?>" required><br><br>
    
    <label for="password">Password:</label><br>
    <input id="password" type="password" name="password" required><br><br>
    
    <label for="confirm_password">Confirm Password:</label><br>
    <input id="confirm_password" type="password" name="confirm_password" required><br><br>
    
    <input id="agree" type="checkbox" name="agree" required> <label for="agree">I agree to the <a href="/terms" target="_blank">Terms of Service</a></label><br><br>
    
    <input type="submit" value="Create Account">
</form>

<p>Already have an account? <a href="/login" data-internal>Log in here</a>.</p>