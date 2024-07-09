<?php

/**
 * This file contains example of generic user authorization.
 * php version 7.4
 *
 * Restore password form.
 * Requires valid security key to access.
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
use ThoPHPAuthorization\Data\User\UserForgotPasswordRequest;

// Get active user.
$user = $user_service->getActiveUser();
// Get security key.
$key = HTTPService::getValue('key');

// If user is signed in or there is no security key - redirect to index.php page.
if ($user || !$key) {
    HTTPService::redirectToPage('/examples/generic/index.php');
}

// Get user request by security key.
$request = $user_access_service->getBySecurity($key);

// If can't get user request or it's invalid - redirect to index.php page.
if (!$request || !($request instanceof UserForgotPasswordRequest) || $request->expired()) {
    HTTPService::redirectToPage('/examples/generic/index.php');
}

// Restore password form result.
$success = false;
// Restore password form errors.
$errors = [];

// Check if form was submited.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from the POST request.
    $form_data = [
        'password' => HTTPService::getPostValue('password'),
        'confirm_password' => HTTPService::getPostValue('confirm_password'),
    ];
    // Validate form data.
    if (empty($form_data['password'])) {
        $errors['password'] = "Please enter user password.";
    }
    if (empty($form_data['confirm_password'])) {
        $errors['confirm_password'] = "Please confirm user password.";
    } elseif (!empty($form_data['password']) && $form_data['confirm_password'] !== $form_data['password']) {
        $errors['confirm_password'] = "Password and confirm password missmatch.";
    }
    // If there were no errors - try to resolve forgot password request.
    if (empty($errors)) {
        $success = true;
        if ($user_access_service->resolveRequest($request, $form_data)) {
            $success = true;
        } else {
            // Failed to resolve forgot password request.
            $errors['form'] = "Failed to change password.";
        }
    }
} else {
    // Set default form data.
    $form_data = [
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
        <?php if ($success) { ?>
            <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-5">Thank you.</h1>
            <p class="col-lg-10 fs-4 mb-5">
                Your have successfuly changed password.
            </p>
            <a href="./index.php" class="btn btn-lg btn-primary">Sign in</a>
        <?php } else { ?>
            <div class="row g-lg-5 py-5">
                <div class="col-xl-6 text-center text-lg-start">
                    <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-4">Change password</h1>
                    <?php include('parts/description.php'); ?>
                </div>
                <div class="col-md-10 mx-auto col-xl-6">
                    <form method="POST" class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
                        <?php if (isset($errors['form'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $errors['form']; ?>
                            </div>
                        <?php } ?>
                        <div class="row gy-3 mb-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input name="password" type="password" class="form-control
                                        <?php if (isset($errors['password'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-password" placeholder="Password"
                                        value="<?= $form_data['password'] ?>">
                                    <label for="sign-up-password">New password</label>
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
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php include('parts/footer.php'); ?>
</body>
</html>