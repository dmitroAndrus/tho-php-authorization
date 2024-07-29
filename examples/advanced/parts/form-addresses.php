<?php

/**
 * This file contains phones fields.
 * php version 7.4
 *
 * @category AdvancedExample
 * @package  ThoPHPAuthorization
 * @author   Dmitro Andrus <dmitro.andrus.dev@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3
 * @link     https://github.com/dmitroAndrus/tho-php-authorization
 */

$field = array_merge(isset($field) ? $field : [], [
    'id' => 'addresses',
    'name' => 'addresses'
]);
$field_values = isset($field_values) ? $field_values : [];
$field_errors = isset($field_errors) ? $field_errors : [];
$json_search = array('\\',"\n","\r","\f","\t","\b","'") ;
$json_replace = array('\\\\',"\\n", "\\r","\\f","\\t","\\b", "\'");
?>

<div id="<?= $field['id'] ?>-container">
    <div id="<?= $field['id'] ?>-fields">
    </div>
    <a href="#" class="btn btn-info btn-sm" data-add-from-tempalte="<?= $field['id'] ?>-template" data-container-id="<?= $field['id'] ?>-fields">add address</a>
</div>
<template id="<?= $field['id'] ?>-template">
    <fieldset id="<?= $field['id'] ?>-{index}" class="position-relative border p-3 mb-3">
        <legend class="h6 mb-0 text-secondary">Additional address</legend>
        <div>
            <div class="row gy-3">
                <div class="col-12">
                    <div class="form-floating">
                        <input name="<?= $field['name'] ?>[{index}][type]" type="text" class="form-control {type_css_valid}"
                            id="<?= $field['id'] ?>-{index}-type" placeholder="Type"
                            value="{type_value}">
                        <label for="<?= $field['id'] ?>-{index}-type">Type</label>
                        <div class="invalid-feedback collapse {type_css_hide_error}">{type_error}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-floating">
                        <input name="<?= $field['name'] ?>[{index}][country]" type="text" class="form-control {country_css_valid}"
                            id="<?= $field['id'] ?>-{index}-country" placeholder="Country"
                            value="{country_value}">
                        <label for="<?= $field['id'] ?>-{index}-country">Country</label>
                        <div class="invalid-feedback collapse {country_css_hide_error}">{country_error}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-floating">
                        <input name="<?= $field['name'] ?>[{index}][state]" type="text" class="form-control {state_css_valid}"
                            id="<?= $field['id'] ?>-{index}-state" placeholder="State"
                            value="{state_value}">
                        <label for="<?= $field['id'] ?>-{index}-state">State</label>
                        <div class="invalid-feedback collapse {state_css_hide_error}">{state_error}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-floating">
                        <input name="<?= $field['name'] ?>[{index}][city]" type="text" class="form-control {city_css_valid}"
                            id="<?= $field['id'] ?>-{index}-city" placeholder="City"
                            value="{city_value}">
                        <label for="<?= $field['id'] ?>-{index}-city">City</label>
                        <div class="invalid-feedback collapse {city_css_hide_error}">{city_error}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-floating">
                        <input name="<?= $field['name'] ?>[{index}][zip]" type="text" class="form-control {zip_css_valid}"
                            id="<?= $field['id'] ?>-{index}-zip" placeholder="ZIP code"
                            value="{zip_value}">
                        <label for="<?= $field['id'] ?>-{index}-zip">ZIP code</label>
                        <div class="invalid-feedback collapse {zip_css_hide_error}">{zip_error}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input name="<?= $field['name'] ?>[{index}][address]" type="text" class="form-control {address_css_valid}"
                            id="<?= $field['id'] ?>-{index}-address" placeholder="Address"
                            value="{address_value}">
                        <label for="<?= $field['id'] ?>-{index}-address">Address</label>
                        <div class="invalid-feedback collapse {address_css_hide_error}">{address_error}</div>
                    </div>
                </div>
            </div>
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