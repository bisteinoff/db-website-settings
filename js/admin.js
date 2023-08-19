/* DB WEBSITE SETTINGS SCRIPTS */

// basic variables

let numPhones = 1     // amount of phone numbers
let numWhatsapps = 1  // amount of whatsapp chats
let numEmails = 1     // amount of emails


// show descriptions

window.addEventListener( "load" , function() {

    let phone, whatsapp, email
    let i

    i = 0
    while ( phone = document.getElementById( "phone_" + i + "_1" ) )
    {
        const phone_desc_1 = document.getElementById( "phone_" + i + "_1_description" )
        const phone_desc_2 = document.getElementById( "phone_" + i + "_2_description" )
        const phone_desc_3 = document.getElementById( "phone_" + i + "_3_description" )

        phone_desc_1.innerText = dbSettingsDescriptions[ "phone" ][ 1 ]
        phone_desc_2.innerText = dbSettingsDescriptions[ "phone" ][ 2 ]
        phone_desc_3.innerText = dbSettingsDescriptions[ "phone" ][ 3 ]
        numPhones = ++i
    }

    i = 0
    while ( whatsapp = document.getElementById( "whatsapp_" + i + "_1" ) )
    {
        const whatsapp_desc_1 = document.getElementById( "whatsapp_" + i + "_1_description" )
        const whatsapp_desc_2 = document.getElementById( "whatsapp_" + i + "_2_description" )
        const whatsapp_desc_3 = document.getElementById( "whatsapp_" + i + "_3_description" )

        whatsapp_desc_1.innerText = dbSettingsDescriptions[ "whatsapp" ][ 1 ]
        whatsapp_desc_2.innerText = dbSettingsDescriptions[ "whatsapp" ][ 2 ]
        whatsapp_desc_3.innerText = dbSettingsDescriptions[ "whatsapp" ][ 3 ]
        numWhatsapps = ++i
    }

    i = 0
    while ( email = document.getElementById( "email_" + i + "_1" ) )
    {
        const email_desc_1 = document.getElementById( "email_" + i + "_1_description" )
        const email_desc_2 = document.getElementById( "email_" + i + "_2_description" )

        email_desc_1.innerText = dbSettingsDescriptions[ "email" ][ 1 ]
        email_desc_2.innerText = dbSettingsDescriptions[ "email" ][ 2 ]
        numEmails = ++i
    }

})


// add element

const buttons = document.getElementById( "db_settings_add_buttons" ).getElementsByTagName( "a" )

const dbButtonPressed = e => {

    let id = e.target.id

    switch (id)
    {
        case "db_settings_add_phone" :
            dbAddPhone();
            break;
        case "db_settings_add_whatsapp" :
            dbAddWhatsapp();
            break;
        case "db_settings_add_email" :
            dbAddEmail();
            break;
    }

}

for (let button of buttons) {

    button.addEventListener("click", dbButtonPressed)

}

function dbAddPhone() {
    let i = numPhones

    const refElement_1 = document.getElementById( "phone_" + (i - 1) + "_3" )
    let newrow_1 = document.createElement("tr")

    newrow_1.setAttribute( "id",  "phone_" + i + "_1" )
    newrow_1.style.verticalAlign = "top"
    newrow_1.innerHTML = 
        '<th scope="row" rowspan="3">' + dbSettingsDescriptions[ "phone" ][ 0 ] + ' ' + (i + 1) + '</th>' +
        '<td rowspan="3"><input type="text" name="phone_' + i + '" id="db_settings_phone_' + i + '" size="20" value="" /></td>' +
        '<td>[db-phone' + (i + 1) + ']</td>' +
        '<td id="phone_' + i + '_1_description">' + dbSettingsDescriptions[ "phone" ][ 1 ] + '</td>' +
        '<td></td>'
    refElement_1.parentNode.insertBefore(newrow_1, refElement_1.nextSibling)

    const refElement_2 = document.getElementById( "phone_" + i + "_1" )
    let newrow_2 = document.createElement("tr")

    newrow_2.setAttribute( "id",  "phone_" + i + "_2" )
    newrow_2.style.verticalAlign = "top"
    newrow_2.innerHTML = 
        '<td>[db-phone' + (i + 1) + '-link]</td>' +
        '<td id="phone_' + i + '_2_description">' + dbSettingsDescriptions[ "phone" ][ 2 ] + '</td>' +
        '<td></td>'
    refElement_2.parentNode.insertBefore(newrow_2, refElement_2.nextSibling)

    const refElement_3 = document.getElementById( "phone_" + i + "_2" )
    let newrow_3 = document.createElement("tr")

    newrow_3.setAttribute( "id",  "phone_" + i + "_3" )
    newrow_3.style.verticalAlign = "top"
    newrow_3.innerHTML = 
        '<td>[db-phone' + (i + 1) + '-href]</td>' +
        '<td id="phone_' + i + '_3_description">' + dbSettingsDescriptions[ "phone" ][ 3 ] + '</td>' +
        '<td></td>'
    refElement_3.parentNode.insertBefore(newrow_3, refElement_3.nextSibling)

    numPhones++
}

function dbAddWhatsapp() {
    let i = numWhatsapps

    const refElement_1 = document.getElementById( "whatsapp_" + (i - 1) + "_3" )
    let newrow_1 = document.createElement("tr")

    newrow_1.setAttribute( "id",  "whatsapp_" + i + "_1" )
    newrow_1.style.verticalAlign = "top"
    newrow_1.innerHTML = 
        '<th scope="row" rowspan="3">' + dbSettingsDescriptions[ "whatsapp" ][ 0 ] + ' ' + (i + 1) + '</th>' +
        '<td rowspan="3"><input type="text" name="whatsapp_' + i + '" id="db_settings_whatsapp_' + i + '" size="20" value="" /></td>' +
        '<td>[db-whatsapp' + (i + 1) + ']</td>' +
        '<td id="whatsapp_' + i + '_1_description">' + dbSettingsDescriptions[ "whatsapp" ][ 1 ] + '</td>' +
        '<td></td>'
    refElement_1.parentNode.insertBefore(newrow_1, refElement_1.nextSibling)

    const refElement_2 = document.getElementById( "whatsapp_" + i + "_1" )
    let newrow_2 = document.createElement("tr")

    newrow_2.setAttribute( "id",  "whatsapp_" + i + "_2" )
    newrow_2.style.verticalAlign = "top"
    newrow_2.innerHTML = 
        '<td>[db-whatsapp' + (i + 1) + '-link]</td>' +
        '<td id="whatsapp_' + i + '_2_description">' + dbSettingsDescriptions[ "whatsapp" ][ 2 ] + '</td>' +
        '<td></td>'
    refElement_2.parentNode.insertBefore(newrow_2, refElement_2.nextSibling)

    const refElement_3 = document.getElementById( "whatsapp_" + i + "_2" )
    let newrow_3 = document.createElement("tr")

    newrow_3.setAttribute( "id",  "whatsapp_" + i + "_3" )
    newrow_3.style.verticalAlign = "top"
    newrow_3.innerHTML = 
        '<td>[db-whatsapp' + (i + 1) + '-href]</td>' +
        '<td id="whatsapp_' + i + '_3_description">' + dbSettingsDescriptions[ "whatsapp" ][ 3 ] + '</td>' +
        '<td></td>'
    refElement_3.parentNode.insertBefore(newrow_3, refElement_3.nextSibling)

    numWhatsapps++
}

function dbAddEmail() {
    let i = numEmails

    const refElement_1 = document.getElementById( "email_" + (i - 1) + "_2" )
    let newrow_1 = document.createElement("tr")

    newrow_1.setAttribute( "id",  "email_" + i + "_1" )
    newrow_1.style.verticalAlign = "top"
    newrow_1.innerHTML = 
        '<th scope="row" rowspan="2">' + dbSettingsDescriptions[ "email" ][ 0 ] + ' ' + (i + 1) + '</th>' +
        '<td rowspan="2"><input type="text" name="email_' + i + '" id="db_settings_email_' + i + '" size="20" value="" /></td>' +
        '<td>[db-email' + (i + 1) + ']</td>' +
        '<td id="email_' + i + '_1_description">' + dbSettingsDescriptions[ "email" ][ 1 ] + '</td>' +
        '<td></td>'
    refElement_1.parentNode.insertBefore(newrow_1, refElement_1.nextSibling)

    const refElement_2 = document.getElementById( "email_" + i + "_1" )
    let newrow_2 = document.createElement("tr")

    newrow_2.setAttribute( "id",  "email_" + i + "_2" )
    newrow_2.style.verticalAlign = "top"
    newrow_2.innerHTML = 
        '<td>[db-email' + (i + 1) + '-link]</td>' +
        '<td id="email_' + i + '_2_description">' + dbSettingsDescriptions[ "email" ][ 2 ] + '</td>' +
        '<td></td>'
    refElement_2.parentNode.insertBefore(newrow_2, refElement_2.nextSibling)

    numEmails++
}