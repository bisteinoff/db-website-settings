/* DB WEBSITE SETTINGS SCRIPTS */

jQuery(document).ready(function ($) {
    // Basic variables
    let numElements = {
        phone: 1,
        whatsapp: 1,
        telegram: 1,
        email: 1,
        address: 1
    };

    // Function to update descriptions
    function updateDescriptions(type) {
        let i = 0;
        while ($(`#${type}_${i}_1`).length) {
            $(`#${type}_${i}_1_description`).text(dbSettingsDescriptions[type][1]);
            $(`#${type}_${i}_2_description`).text(dbSettingsDescriptions[type][2]);
            $(`#${type}_${i}_3_description`).text(dbSettingsDescriptions[type][3]);
            numElements[type] = ++i;
        }
    }

    // Initialize descriptions
    $.each(numElements, function (key) {
        updateDescriptions(key);
    });

    // Add elements dynamically
    $("#db_settings_add_buttons a").on("click", function () {
        let type = this.id.replace("db_settings_add_", "");
        addElement(type);
    });

    function addElement(type) {
        let i = numElements[type];
        let refElement = $(`#${type}_${i - 1}_3`);

        if (!refElement.length) return;

        let rows = [
            `<tr id="${type}_${i}_1" style="vertical-align: top;">
                <th scope="row" rowspan="3">${dbSettingsDescriptions[type][0]} ${i + 1}</th>
                <td rowspan="3"><input type="text" name="${type}_${i}" id="db_settings_${type}_${i}" size="20" value="" /></td>
                <td>[db-${type}${i + 1}]</td>
                <td id="${type}_${i}_1_description">${dbSettingsDescriptions[type][1]}</td>
                <td></td>
            </tr>`,
            `<tr id="${type}_${i}_2" style="vertical-align: top;">
                <td>[db-${type}${i + 1}-link]</td>
                <td id="${type}_${i}_2_description">${dbSettingsDescriptions[type][2]}</td>
                <td></td>
            </tr>`,
            `<tr id="${type}_${i}_3" style="vertical-align: top;">
                <td>[db-${type}${i + 1}-href]</td>
                <td id="${type}_${i}_3_description">${dbSettingsDescriptions[type][3]}</td>
                <td></td>
            </tr>`
        ];

        $(rows.join("\n")).insertAfter(refElement);
        numElements[type]++;
    }

    // Settings for different contact types
    let dbSettingsTypes = {
        phone: { protocol: 'tel:', link: '', reg: /[^+\d]/g },
        whatsapp: { protocol: '', link: 'https://wa.me/', reg: /\D/g },
        telegram: { protocol: '', link: 'https://t.me/', hashtag: '@' },
        email: { protocol: 'mailto:', link: '' },
        address: { protocol: '', link: 'https://www.google.com/maps/search/', target: '_blank', rel: 'nofollow noopener noreferrer', reg: /\s/g, replace: '+' }
    };

    // Handle input changes dynamically
    $(document).on('input', 'input[id^="db_settings_"]', function () {
        let inputId = $(this).attr('id');
        let type = inputId.split('_')[2];
        let index = inputId.split('_').pop();
        let newValue = $(this).val();

        if (dbSettingsTypes[type]) {
            let cleanValue = dbSettingsTypes[type].reg ? newValue.replace(dbSettingsTypes[type].reg, dbSettingsTypes[type].replace ?? '') : newValue;
            newValue = dbSettingsTypes[type].hashtag ? dbSettingsTypes[type].hashtag + newValue : newValue;

            let codeText = `<span class="db-wcs-contact db-wcs-contact-${type} db-wcs-contact-${type}-${index}">${newValue}</span>`;
            let targetAttr = dbSettingsTypes[type].target ? ` target="${dbSettingsTypes[type].target}"` : '';
            let relAttr = dbSettingsTypes[type].rel ? ` rel="${dbSettingsTypes[type].rel}"` : '';
            let codeLink = `<a href="${dbSettingsTypes[type].protocol}${dbSettingsTypes[type].link}${cleanValue}" class="db-wcs-contact db-wcs-contact-${type} db-wcs-contact-${type}-${index}"${targetAttr}${relAttr}>${newValue}</a>`;
            let codeHref = dbSettingsTypes[type].link + cleanValue;

            $(`#${type}_${index}_1 td:last-child`).html(codeText);
            $(`#${type}_${index}_2 td:last-child`).html(codeLink);
            $(`#${type}_${index}_3 td:last-child`).html(codeHref);
        }
    });
});