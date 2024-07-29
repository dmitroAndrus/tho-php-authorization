<?php

/**
 * This file contains example of advanced user authorization.
 * php version 7.4
 *
 * Forgot password form.
 * When existing user email is entered: it will send email with a link to `restore-password.php`
 * page with unique security key to change user password.
 *
 * @category AdvancedExample
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

// If there is active user - redirect to index.php page.
if ($user) {
    HTTPService::redirectToPage(URL_PATH . 'index.php');
}

// Forgot password form result.
$success = false;
// Forgot password form errors.
$errors = [];

// Check if form was submited.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from the POST request.
    $form_data = [
        'email' => HTTPService::getPostValue('email'),
    ];
    if (empty($form_data['email'])) {
        $errors['email'] = "Please enter Your email.";
    }
    // Validate form data.
    if (empty($errors)) {
        // try to get user by provided email.
        $user = $user_source->getByEmail($form_data['email']);
        // If user found - send email with link to restore pessword.
        if ($user) {
            // Create forgot password request.
            $request = $user_access_service->createForgotPasswordRequest($user);
            if ($request) {
                $success = true;
                // Set mail template data.
                $template_data = [
                    'url' => HTTPService::relativeToURL(
                        URL_PATH . "restore-password.php?key={$request->getSecurity()}"
                    )
                ];
                // Set mail data.
                $mail_data = [
                    'subject' => 'Restore password request',
                    'text' => TemplatingService::readTemplateFile(realpath('./mail/forgot-password.txt'), $template_data),
                    'html' => TemplatingService::readTemplateFile(realpath('./mail/forgot-password.html'), $template_data),
                    'from' => SMTP_SENDER_EMAIL,
                    'sender' => SMTP_SENDER_EMAIL,
                    'receiver' => $user->getEmail(),
                    'reply_to' => SMTP_REPLYTO_EMAIL
                ];
                // Send mail to user.
                $mail_service->send($mail_data);
            } else {
                // Failed to create request.
                $errors['form'] = "Failed to create request.";
            }
        } else {
            // User not found error.
            $errors['form'] = "User with such email not found.";
        }
    }
} else {
    // Set default form data.
    $form_data = [
        'email' => '',
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
                Mail letter with instructions was sent to your E-Mail.
            </p>
            <a href="./index.php" class="btn btn-lg btn-primary">Sign in</a>
        <?php } else { ?>
            <div class="row g-lg-5 py-5">
                <div class="col-xl-6 text-center text-lg-start">
                    <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-4">Forgot password</h1>
                    <?php include('parts/description.php'); ?>
                </div>
                <div class="col-md-10 mx-auto col-xl-6">
                    <form method="POST" class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
                        <p class="mb-4">
                            Please enter Your E-Mail address and mail letter with instructions will be sent to it
                        </p>
                        <?php if (isset($errors['form'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $errors['form']; ?>
                            </div>
                        <?php } ?>
                        <div class="row gy-3 mb-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input name="email" type="email" class="form-control
                                        <?php if (isset($errors['email'])) { ?>
                                            is-invalid
                                        <?php } ?>"
                                        id="sign-up-email" placeholder="Email" value="<?= $form_data['email'] ?>">
                                    <label for="sign-up-email">Email</label>
                                    <?php if (isset($errors['email'])) { ?>
                                        <div class="invalid-feedback"><?= $errors['email'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Send</button>
                        <hr class="my-4">
                        <small class="text-body-secondary">
                            Have a second thought? <a href="./index.php">Sign in</a>
                        </small>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php include('parts/footer.php'); ?>
</body>
</html>