<?php

/**
 * This file contains example of generic user authorization.
 * php version 7.4
 *
 * Edit signed in user details.
 *
 * Form fields:
 * * First name
 * * Last name
 * * Birthday
 * * Country
 * * State
 * * City
 * * Zip code
 * * Address
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
$active_tab = 'edit-details';
// Edit form result.
$success = false;
// Edit form errors.
$errors = [];

// Check if form was submited.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from the POST request.
    $form_data = [
        'first_name' => HTTPService::getPostValue('first_name'),
        'last_name' => HTTPService::getPostValue('last_name'),
        'birthday' => HTTPService::getPostValue('birthday'),
        'country' => HTTPService::getPostValue('country'),
        'state' => HTTPService::getPostValue('state'),
        'city' => HTTPService::getPostValue('city'),
        'address' => HTTPService::getPostValue('address'),
        'zip' => HTTPService::getPostValue('zip'),
    ];
    // Validate form data.
    if (empty($form_data['first_name'])) {
        $errors['first_name'] = "Please enter Your First name.";
    }
    if (empty($form_data['last_name'])) {
        $errors['last_name'] = "Please enter Your Last name.";
    }
    if (empty($form_data['country'])) {
        $errors['country'] = "Please enter Your Country.";
    }
    if (empty($form_data['state'])) {
        $errors['state'] = "Please enter Your State.";
    }
    if (empty($form_data['city'])) {
        $errors['city'] = "Please enter Your City.";
    }
    if (empty($form_data['address'])) {
        $errors['address'] = "Please enter Your address.";
    }
    if (empty($form_data['zip'])) {
        $errors['zip'] = "Please enter Your ZIP code.";
    }
    // If there were no errors - try to edit user.
    if (empty($errors)) {
        if ($user_service->edit($user, $form_data)) {
            $success = true;
            // Renew form data.
            $form_data = [
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'birthday' => $user->getBirthday('Y-m-d'),
                'country' => $user->getCountry(),
                'state' => $user->getState(),
                'city' => $user->getCity(),
                'address' => $user->getAddress(),
                'zip' => $user->getZIP(),
            ];
        } else {
            // User edit failed failed.
            $errors['form'] = "Failed to edit user.";
        }
    }
} else {
    // Set default form data.
    $form_data = [
        'first_name' => $user->getFirstName(),
        'last_name' => $user->getLastName(),
        'birthday' => $user->getBirthday('Y-m-d'),
        'country' => $user->getCountry(),
        'state' => $user->getState(),
        'city' => $user->getCity(),
        'address' => $user->getAddress(),
        'zip' => $user->getZIP(),
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
            <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-5">Edit user details</h1>
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
                    <div class="col-12 col-sm-6">
                        <div class="form-floating">
                            <input name="first_name" type="text" class="form-control
                                <?php if (isset($errors['first_name'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="edit-user-details-first-name" placeholder="First name"
                                value="<?= $form_data['first_name'] ?>">
                            <label for="edit-user-details-first-name">First name</label>
                            <?php if (isset($errors['first_name'])) { ?>
                                <div class="invalid-feedback"><?= $errors['first_name'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-floating">
                            <input name="last_name" type="text" class="form-control
                                <?php if (isset($errors['last_name'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="edit-user-details-last-name" placeholder="Last name"
                                value="<?= $form_data['last_name'] ?>">
                            <label for="edit-user-details-last-name">Last name</label>
                            <?php if (isset($errors['last_name'])) { ?>
                                <div class="invalid-feedback"><?= $errors['last_name'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <input name="birthday" type="text" class="form-control
                                <?php if (isset($errors['birthday'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="edit-user-details-birthday" placeholder="Birthday"
                                value="<?= $form_data['birthday'] ?>">
                            <label for="edit-user-details-birthday">Birthday</label>
                            <?php if (isset($errors['birthday'])) { ?>
                                <div class="invalid-feedback"><?= $errors['birthday'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-floating">
                            <input name="country" type="text" class="form-control
                                <?php if (isset($errors['country'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="edit-user-details-country" placeholder="Country" value="<?= $form_data['country'] ?>">
                            <label for="edit-user-details-country">Country</label>
                            <?php if (isset($errors['country'])) { ?>
                                <div class="invalid-feedback"><?= $errors['country'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-floating">
                            <input name="state" type="text" class="form-control
                                <?php if (isset($errors['state'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="edit-user-details-state" placeholder="State" value="<?= $form_data['state'] ?>">
                            <label for="edit-user-details-state">State</label>
                            <?php if (isset($errors['state'])) { ?>
                                <div class="invalid-feedback"><?= $errors['state'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-floating">
                            <input name="city" type="text" class="form-control
                                <?php if (isset($errors['city'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="edit-user-details-city" placeholder="City" value="<?= $form_data['city'] ?>">
                            <label for="edit-user-details-city">City</label>
                            <?php if (isset($errors['city'])) { ?>
                                <div class="invalid-feedback"><?= $errors['city'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-floating">
                            <input name="zip" type="text" class="form-control
                                <?php if (isset($errors['zip'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="edit-user-details-zip" placeholder="ZIP code" value="<?= $form_data['zip'] ?>">
                            <label for="edit-user-details-zip">ZIP code</label>
                            <?php if (isset($errors['zip'])) { ?>
                                <div class="invalid-feedback"><?= $errors['zip'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <input name="address" type="text" class="form-control
                                <?php if (isset($errors['address'])) { ?>
                                    is-invalid
                                <?php } ?>"
                                id="edit-user-details-address" placeholder="Address" value="<?= $form_data['address'] ?>">
                            <label for="edit-user-details-address">Address</label>
                            <?php if (isset($errors['address'])) { ?>
                                <div class="invalid-feedback"><?= $errors['address'] ?></div>
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