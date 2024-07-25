// Custom templating
custom_templating = {
    // Taken from https://stackoverflow.com/questions/494143/creating-a-new-dom-element-from-an-html-string-using-built-in-dom-methods-or-pro/35385518#35385518
    fromHTML: (html, trim = true) => {
        // Process the HTML string.
        html = trim ? html.trim() : html;
        if (!html) return null;

        // Then set up a new template element.
        const template = document.createElement('template');
        template.innerHTML = html;
        const result = template.content.children;
        return result;
    },
    replace: (str, data) => {
        return str.replace(/\{([-_0-9a-zA-Z]+)\}/gi, (match, key) => {
            if (typeof data[key] !== 'undefined') {
                return data[key]
            }
            return '';
        });
    },
    add: (container_id, template_id, data = {}) => {
        // Get and check container and template.
        const container = container_id instanceof Element
                ? container_id
                : document.getElementById(container_id),
            template = document.getElementById(template_id);
        if (!(container && template)) {
            return false;
        }
        if (!template.dataset.lastIndex) {
            template.dataset.lastIndex = 1;
        } else {
            ++template.dataset.lastIndex;
        }
        const data_copy = {
                ...data,
                index: template.dataset.lastIndex
            },
            copyEls = custom_templating.fromHTML(custom_templating.replace(
            template.innerHTML,
            data_copy
        ));
        if (copyEls.length) {
            container.append(...copyEls);
            return true;
        }
        return false;
    },
    remove: (container_id) => {
        const container = container_id instanceof Element
                ? container_id
                : document.getElementById(container_id);
        if (container) {
            container.remove();
        }
    },
    addFields: (container_id, template_id, fields_values, fields_errors) => {
        let fields_list,
            fields_data,
            key,
            name;
        if (!fields_values) {
            return;
        }
        const values_obj = Array.isArray(fields_values)
                ? Object.assign(fields_values)
                : fields_values,
            errors_obj = fields_errors
                ? (Array.isArray(fields_errors)
                    ? Object.assign(fields_errors)
                    : fields_errors)
                : {};
        for (key in values_obj) {
            if (values_obj.hasOwnProperty(key)) {
                fields_data = {};
                for (name in values_obj[key]) {
                    if (values_obj[key].hasOwnProperty(name)) {
                        fields_data[name + '_value'] = values_obj[key][name];
                    }
                }
                if (errors_obj.hasOwnProperty(key)) {
                    for (name in errors_obj[key]) {
                        if (errors_obj[key].hasOwnProperty(name)) {
                            fields_data[name + '_css_valid'] = 'is-invalid';
                            fields_data[name + '_css_hide_error'] = 'show';
                            fields_data[name + '_error'] = errors_obj[key][name];
                        }
                    }
                }
                custom_templating.add(container_id, template_id, fields_data);
            }
        }
    }
}

const setup_elements = (root_el) => {
    const root = root_el instanceof Element
        ? root_el
        : document;
    root.querySelectorAll('[data-flatpickr]').forEach((element) => {
        flatpickr(element, {
            maxDate: 'today'
        });
    });

    root.querySelectorAll('[data-add-from-tempalte]').forEach((element) => {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            const template_id = this.dataset.addFromTempalte,
                container = this.dataset.containerId
                    ? document.getElementById(this.dataset.containerId)
                    : this;
            if (template_id && container) {
                return custom_templating.add(container, template_id);
            }
            return false;
        });
    });

    root.querySelectorAll('[data-remove-by-id]').forEach((element) => {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            custom_templating.remove(element.dataset.removeById);
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setup_elements();
});