<?php

use Core\Helpers;

if (Helpers::isLoggedIn()): ?>
<div id="userMenu" onclick="toggleDropdown()">
    <span><?= htmlspecialchars(Helpers::name()) ?></span>
    <img src="<?= htmlspecialchars(Helpers::avatar()) ?>" height="48">
    <div id="options">
        <?php if (Helpers::isAdmin()): ?>
        <a href="/dashboard" data-internal>Dashboard</a>
        <?php else: ?>
        <a href="/mylibrary" data-internal>My Library</a>
        <?php endif; ?>
        <a href="/config" data-internal>Configuration</a>
        <a href="/logout">Log Out</a>
    </div>
</div>
<?php else: ?>
<div id="authMenu">
    <a id="signup" href="/signup" data-internal>Sign Up</a>
    <a id="login" href="/login" data-internal>Log In</a>
</div>
<?php endif; ?>