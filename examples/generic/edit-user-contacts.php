<?php

/**
 * This file contains example of generic user authorization.
 * php version 7.4
 *
 * Edit signed in user contact data.
 * Will require current user password to do so.
 *
 * Form fields:
 * * User name
 * * Email
 * * Phone
 * * Current password
 *
 * @category GenericExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

require_once('./includes/start-autoload.php');

use ThoPHPAuthorization\Service\HTTPService;
use ThoPHPAuthorization\Service\TemplatingService;

// Get active user.
$user = $user_service->getActiveUser();

// If there is no active user - redirect to index.php page.
if (!$user) {
    HTTPService::redirectToPage(URL_PATH . 'index.php');
}

// Current active tab.
$active_tab = 'edit-contacts';
// Edit form result.
$success = false;
// Edit form errors.
$errors = [];

// Check if form was submited.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from the POST request.
    $form_data = [
        'name' => HTTPService::getPostValue('name'),
        'email' => HTTPService::getPostValue('email'),
        'phone' => HTTPService::getPostValue('phone'),
        'validate_password' => HTTPService::getPostValue('validate_password'),
    ];
    // Validate form data.
    if (empty($form_data['name'])) {
        $errors['name'] = "Please enter user name.";
    }
    if (empty($form_data['email'])) {
        $errors['email'] = "Please enter Your email.";
    }
    if (empty($form_data['phone'])) {
        $errors['phone'] = "Please enter Your phone number.";
    }
    // Check current user password.
    if (empty($form_data['validate_password'])) {
        $errors['validate_password'] = "Please enter user password.";
    } elseif (!empty($form_data['password']) && $user->checkSecurity($form_data['password'])) {
        $errors['validate_password'] = "Wrong password. Please enter correct password.";
    }
    // If there were no errors - try to edit user.
    if (empty($errors)) {
        if ($user_service->edit($user, $form_data)) {
            $success = true;
            // Renew form data.
            $form_data = [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'phone' => $user->getPhone('Y-m-d'),
                'validate_password' => '',
            ];
        } else {
            // User edit failed failed.
            $errors['form'] = "Failed to edit user. User with such name or email may already exist.";
        }
    }
} else {
    // Set default form data.
    $form_data = [
        'name' => $user->getName(),
        'email' => $user->getEmail(),
        'phone' => $user->getPhone('Y-m-d'),
        'validate_password' => '',
    ];
}

?>
<!DOCTYPE html>
<html>
<?php include('parts/head.php'); ?>
<body>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <?php include('parts/user-tabs.php'); ?>
        <div>
            <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-5">Edit user contact data</h1>
            <form method="POST" class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
                <?php if ($success) { ?>
                    <div class="alert alert-success" role="alert">
                        Changes have been saved
                    </div>
                <?php } ?>
                <?php if (isset($errors['form'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $errors['form']; ?>
                    </div>
                <?php } ?>
                <div class="row gy-3 mb-3">
                    <div class="col-12">
                        <div class="form-floating">
                            <input name="name" type="text" class="form-control
                                <?php if (isset($errors['name'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="edit-user-contacts-name" placeholder="User name" value="<?= $form_data['name'] ?>">
                            <label for="edit-user-contacts-name">User name</label>
                            <?php if (isset($errors['name'])) { ?>
                                <div class="invalid-feedback"><?= $errors['name'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <input name="email" type="email" class="form-control
                                <?php if (isset($errors['email'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="edit-user-contacts-email" placeholder="Email" value="<?= $form_data['email'] ?>">
                            <label for="edit-user-contacts-email">Email</label>
                            <?php if (isset($errors['email'])) { ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <input name="phone" type="tel" class="form-control
                                <?php if (isset($errors['phone'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="edit-user-contacts-phone" placeholder="Phone number"
                                value="<?= $form_data['phone'] ?>">
                            <label for="edit-user-contacts-phone">Phone number</label>
                            <?php if (isset($errors['phone'])) { ?>
                                <div class="invalid-feedback"><?= $errors['phone'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <input name="validate_password" type="password" class="form-control
                                <?php if (isset($errors['validate_password'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="edit-user-contacts-confirm-password" placeholder="Please enter Your current password"
                                value="<?= $form_data['validate_password'] ?>">
                            <label for="edit-user-contacts-confirm-password">Current password</label>
                            <?php if (isset($errors['validate_password'])) { ?>
                                <div class="invalid-feedback"><?= $errors['validate_password'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
    <?php include('parts/footer.php'); ?>
</body>
</html>