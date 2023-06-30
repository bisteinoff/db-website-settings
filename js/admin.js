/* DB WEBSITE SETTINGS SCRIPTS */

// show descriptions

window.addEventListener( "load" , function() {
    const phone_1 = document.getElementById( "phone_0_1_description" )
    const phone_2 = document.getElementById( "phone_0_2_description" )
    const whatsapp_1 = document.getElementById( "whatsapp_0_1_description" )
    const whatsapp_2 = document.getElementById( "whatsapp_0_2_description" )
    const whatsapp_3 = document.getElementById( "whatsapp_0_3_description" )
    const email_1 = document.getElementById( "email_0_1_description" )
    const email_2 = document.getElementById( "email_0_2_description" )

    phone_1.innerText = dbSettingsDescriptions[ "phone" ][ 0 ]
    phone_2.innerText = dbSettingsDescriptions[ "phone" ][ 1 ]
    whatsapp_1.innerText = dbSettingsDescriptions[ "whatsapp" ][ 0 ]
    whatsapp_2.innerText = dbSettingsDescriptions[ "whatsapp" ][ 1 ]
    whatsapp_3.innerText = dbSettingsDescriptions[ "whatsapp" ][ 2 ]
    email_1.innerText = dbSettingsDescriptions[ "email" ][ 0 ]
    email_2.innerText = dbSettingsDescriptions[ "email" ][ 1 ]
})


// add element

const buttons = document.getElementById( "db_add_buttons" ).getElementsByTagName( "a" )

const buttonPressed = e => {

    let id = e.target.id
    console.log( id )

}

for (let button of buttons) {

    button.addEventListener("click", buttonPressed)

}