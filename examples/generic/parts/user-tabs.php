<ul class="nav nav-tabs mb-5">
    <li class="nav-item">
        <a class="nav-link<?php if ($active_tab == 'details') { ?> active<?php } ?>" href="./index.php">Details</a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php if ($active_tab == 'edit-details') { ?> active<?php } ?>" href="./edit-user-details.php">Edit details</a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php if ($active_tab == 'edit-contacts') { ?> active<?php } ?>" href="./edit-user-contacts.php">Edit contact information</a>
    </li>
    <li class="nav-item me-auto">
        <a class="nav-link<?php if ($active_tab == 'change-password') { ?> active<?php } ?>" href="./change-password.php">Change password</a>
    </li>
    <li class="nav-item">
        <a class="btn btn-warning" href="./sign-out.php">Sign out</a>
    </li>
</ul>