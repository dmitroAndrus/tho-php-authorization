<?php

/**
 * This file contains example of simple user authorization.
 * php version 7.4
 *
 * Sign up user form.
 *
 * Form fields: user name, password.
 *
 * @category SimpleExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

require_once('./includes/start.php');

use ThoPHPAuthorization\Service\HTTPService;

// Get active user.
$user = $user_service->getActiveUser();

// If there is active user - redirect to index.php page.
if ($user) {
    HTTPService::redirectToPage(URL_PATH . 'index.php');
}

// Sign up result.
$success = false;
// Sign up errors.
$errors = [];

// Check if sing up form was submited.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from the POST request.
    $form_data = [
        'name' => HTTPService::getPostValue('name'),
        'password' => HTTPService::getPostValue('password'),
        'confirm_password' => HTTPService::getPostValue('confirm_password'),
    ];
    // Validate form data.
    if (empty($form_data['name'])) {
        $errors['name'] = "Please enter user name.";
    }
    if (empty($form_data['password'])) {
        $errors['password'] = "Please enter user password.";
    }
    if (empty($form_data['confirm_password'])) {
        $errors['confirm_password'] = "Please confirm user password.";
    } elseif (!empty($form_data['password']) && $form_data['confirm_password'] !== $form_data['password']) {
        $errors['confirm_password'] = "Password and confirm password missmatch.";
    }
    // If there were no errors - try to sign up user.
    if (empty($errors)) {
        if ($user_service->signUp($form_data)) {
            $success = true;
        } else {
            // Sign up failed.
            $errors['form'] = "Failed to create user or user with such name already exists.";
        }
    }
} else {
    // Set default form data.
    $form_data = [
        'name' => '',
        'password' => '',
        'confirm_password' => '',
    ];
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Simple example of User Authorization</title>
    <link href="./assets/bootstrap-5.3.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <?php if ($success) { ?>
            <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-5">Thank you.</h1>
            <p class="col-lg-10 fs-4 mb-5">
                Your User was successfuly signed up! You can now sign in with it.
            </p>
            <a href="./index.php" class="btn btn-lg btn-primary">Sign in</a>
        <?php } else { ?>
            <div class="row g-lg-5 py-5">
                <div class="col-lg-7 text-center text-lg-start">
                    <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-4">Simple example of User Authorization</h1>
                    <p class="col-lg-10 fs-4">
                        This is an example of Sign Up form.
                        The form is built entirely with Bootstrap’s form controls.
                    </p>
                    <p>
                        You will be able to sign in with user name only.<br/>
                        User have such fields:<br/>
                        - User name<br/>
                        - Password
                    </p>
                </div>
                <div class="col-md-10 mx-auto col-lg-5">
                    <form method="POST" class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
                        <?php if (isset($errors['form'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $errors['form']; ?>
                            </div>
                        <?php } ?>
                        <div class="form-floating mb-3">
                            <input name="name" type="text" class="form-control
                                <?php if (isset($errors['name'])) { ?>
                                    is-invalid
                                <?php } ?>" id="sign-up-name" placeholder="User name" value="<?= $form_data['name'] ?>">
                            <label for="sign-up-name">User name</label>
                            <?php if (isset($errors['name'])) { ?>
                                <div class="invalid-feedback"><?= $errors['name'] ?></div>
                            <?php } ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" class="form-control
                                <?php if (isset($errors['password'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="sign-up-password" placeholder="Password" value="<?= $form_data['password'] ?>">
                            <label for="sign-up-password">Password</label>
                            <?php if (isset($errors['password'])) { ?>
                                <div class="invalid-feedback"><?= $errors['password'] ?></div>
                            <?php } ?>
                        </div>
                        <div class="form-floating mb-3">
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
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
                        <hr class="my-4">
                        <small class="text-body-secondary">
                            Already have user? <a href="./index.php">Sign in</a>
                        </small>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>