<?php

/**
 * This file contains example of generic user authorization.
 * php version 7.4
 *
 * Change signed in user password.
 * Will require current user password to do so.
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
    HTTPService::redirectToPage('/examples/generic/index.php');
}

// Current active tab.
$active_tab = 'change-password';
// Change password result.
$success = false;
// Change password erros.
$errors = [];

// Check if forgot password form was submited.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from the POST request.
    $form_data = [
        'validate_password' => HTTPService::getPostValue('validate_password'),
        'password' => HTTPService::getPostValue('password'),
        'confirm_password' => HTTPService::getPostValue('confirm_password'),
    ];
    // Check current user password.
    if (empty($form_data['validate_password'])) {
        $errors['validate_password'] = "Please enter current user password.";
    } elseif (!empty($form_data['password']) && $user->checkSecurity($form_data['password'])) {
        $errors['validate_password'] = "Wrong current password. Please enter correct password.";
    }
    // Check new user password.
    if (empty($form_data['password'])) {
        $errors['password'] = "Please enter user password.";
    }
    if (empty($form_data['confirm_password'])) {
        $errors['confirm_password'] = "Please confirm user password.";
    } elseif (!empty($form_data['password']) && $form_data['confirm_password'] !== $form_data['password']) {
        $errors['confirm_password'] = "Password and confirm password missmatch.";
    }
    // If there were no errors - try to edit user and set new password.
    if (empty($errors)) {
        if ($user_service->edit($user, $form_data)) {
            $success = true;
            // Reset user data.
            $form_data = [
                'validate_password' => '',
                'password' => '',
                'confirm_password' => '',
            ];
        } else {
            // User edit failed failed.
            $errors['form'] = "Failed to change user password.";
        }
    }
} else {
    // Set default form data.
    $form_data = [
        'validate_password' => '',
        'password' => '',
        'confirm_password' => '',
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
                    <div class="col-12">
                        <div class="form-floating">
                            <input name="password" type="password" class="form-control
                                <?php if (isset($errors['password'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="sign-up-password" placeholder="Password"
                                value="<?= $form_data['password'] ?>">
                            <label for="sign-up-password">Password</label>
                            <?php if (isset($errors['password'])) { ?>
                                <div class="invalid-feedback"><?= $errors['password'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <input name="confirm_password" type="password" class="form-control
                                <?php if (isset($errors['confirm_password'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="sign-up-confirm-password" placeholder="Confirm password"
                                value="<?= $form_data['confirm_password'] ?>">
                            <label for="sign-up-confirm-password">Confirm password</label>
                            <?php if (isset($errors['confirm_password'])) { ?>
                                <div class="invalid-feedback"><?= $errors['confirm_password'] ?></div>
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