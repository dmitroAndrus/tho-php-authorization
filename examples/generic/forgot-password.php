<?php

/**
 * This file contains example of generic user authorization.
 * php version 7.4
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

$user = $user_service->getActiveUser();

if ($user) {
    HTTPService::redirectToPage('/examples/generic/index.php');
}
$success = false;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_data = [
        'email' => HTTPService::getPostValue('email'),
    ];
    if (empty($form_data['email'])) {
        $errors['email'] = "Please enter Your email.";
    }
    if (empty($errors)) {
        $user = $user_source->getByEmail($form_data['email']);
        if ($user) {
            $success = true;
            $request = $user_access_service->createForgotPasswordRequest($user);
            $mail_data = [
                'url' => HTTPService::relativeToURL(
                    "/examples/generic/restore-password.php?key={$request->getSecurity()}"
                )
            ];
            // Send user email
            $mail_data = [
                'subject' => 'Restore password request',
                'text' => TemplatingService::readTemplateFile(realpath('./mail/forgot-password.txt'), $mail_data),
                'html' => TemplatingService::readTemplateFile(realpath('./mail/forgot-password.html'), $mail_data),
                'from' => SMTP_SENDER_EMAIL,
                'sender' => SMTP_SENDER_EMAIL,
                'receiver' => $user->getEmail(),
                'reply_to' => SMTP_REPLYTO_EMAIL
            ];
            $mail_service->send($mail_data);
        } else {
            $errors['form'] = "User with such email not found.";
        }
    }
} else {
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