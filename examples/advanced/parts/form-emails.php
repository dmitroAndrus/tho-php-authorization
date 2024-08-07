<?php

/**
 * This file contains emails fields.
 * php version 7.4
 *
 * @category AdvancedExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

$field = array_merge(isset($field) ? $field : [], [
    'id' => 'emails',
    'name' => 'emails'
]);
$field_values = isset($field_values) ? $field_values : [];
$field_errors = isset($field_errors) ? $field_errors : [];
$json_search = array('\\',"\n","\r","\f","\t","\b","'") ;
$json_replace = array('\\\\',"\\n", "\\r","\\f","\\t","\\b", "\'");
?>

<div id="<?= $field['id'] ?>-container">
    <div id="<?= $field['id'] ?>-fields">
    </div>
    <a href="#" class="btn btn-info btn-sm" data-add-from-tempalte="<?= $field['id'] ?>-template" data-container-id="<?= $field['id'] ?>-fields">add email</a>
</div>
<template id="<?= $field['id'] ?>-template">
    <fieldset id="<?= $field['id'] ?>-{index}" class="position-relative border p-3 mb-3">
        <legend class="h6 mb-3 text-secondary">Additional email</legend>
        <div class="form-floating mb-3">
            <input name="<?= $field['name'] ?>[{index}][type]" type="text" class="form-control {type_css_valid}"
                id="<?= $field['id'] ?>-{index}-type" placeholder="Type"
                value="{type_value}">
            <label for="<?= $field['id'] ?>-{index}-type">Type</label>
            <div class="invalid-feedback collapse {type_css_hide_error}">{type_error}</div>
        </div>
        <div class="form-floating">
            <input name="<?= $field['name'] ?>[{index}][email]" type="email" class="form-control {email_css_valid}"
                id="<?= $field['id'] ?>-{index}-email" placeholder="Email"
                value="{email_value}">
            <label for="<?= $field['id'] ?>-{index}-email">Email</label>
            <div class="invalid-feedback collapse {email_css_hide_error}">{email_error}</div>
        </div>
        <a href="#" class="btn btn-danger btn-sm position-absolute top-0 end-0" data-remove="<?= $field['id'] ?>-{index}">remove</a>
    </fieldset>
</template>

<script type="text/javascript">
    (() => {
        const field_values = '<?= str_replace($json_search, $json_replace, json_encode($field_values)); ?>',
            field_errors = '<?= str_replace($json_search, $json_replace, json_encode($field_errors)); ?>';
        if (field_values) {
            document.addEventListener('DOMContentLoaded', () => {
                custom_templating.addFields(
                    '<?= $field['id'] ?>-fields',
                    '<?= $field['id'] ?>-template',
                    JSON.parse(field_values),
                    field_errors ? JSON.parse(field_errors) : null
                );
            });
        }
    })();
</script>