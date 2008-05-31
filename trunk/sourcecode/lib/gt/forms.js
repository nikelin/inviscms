/**
 * Forms prototypes
 * Author: InnoWeb Studio
 *
 * All rights reserved, 2008
 **/
var rf = Invis.tools.form_reg('reg_form', 7);
Invis.tools.form_append_field('reg_form', {
	name:'email',
    label: 'адрес',
    type: 'string',
    imp: true,
    ml: 3
}); 
Invis.tools.form_append_field('reg_form', {
	name:'remail',
    label:'повторный адрес',
    type: 'string',
    imp: true,
    ml: 5
});
Invis.tools.form_append_field('reg_form', {
	name:'country',
    label:'страна',
    type: 'string',
    imp: true,
    ml: 5
});
Invis.tools.form_append_field('reg_form', {
	name:'city',
    label:'город',
    type: 'string',
    imp: true,
    ml: 5
});
Invis.tools.form_append_field('reg_form', {
	name:'passwd',
    label:'пароль',
    type: 'string',
    imp: true,
    ml: 5
});
Invis.tools.form_append_field('reg_form', {
	name:'retype',
    label:'повторный пароль',
    type: 'string',
    imp: true,
    ml: 5
});

var se=Invis.tools.form_reg('subscription',3);
Invis.tools.form_append_field('regForm', {
	name:'email',
    label: 'e-mail',
    type: 'string',
    imp: true,
    ml: 5
});

var ba=Invis.tools.form_reg('bad_advertising',4);
Invis.tools.form_append_field('bad_advertising', {
    name: 'subject',
	label: 'суть жалобы',
    type: 'string',
    imp: true,
    ml: 5
});
Invis.tools.form_append_field('bad_advertising', {
    name: 'name',
	label: 'имя отправителя',
    type: 'string',
    imp: true,
    ml: 2
});
Invis.tools.form_append_field('bad_advertising', {
    name: 'contacts',
	label: 'контактная информация',
    type: 'string',
    imp: true,
    ml: 5
});

var se=Invis.tools.form_reg('auth_form',4);
Invis.tools.form_append_field('auth_form', {
	name:'login',
    label: 'логин',
    type: 'string',
    imp: true,
    ml: 3
});
Invis.tools.form_append_field('auth_form', {
	name:'passwd',
    label: 'пароль',
    type: 'string',
    imp: true,
    ml: 4
});
Invis.tools.form_append_field('auth_form', {
	name:'remember',
    label: 'логин',
    type: 'bool',
    imp: false,
    ml: 1
});

var cpq=Invis.tools.form_reg("change_quantity",3);
Invis.tools.form_append_field('change_quantity', {
	name:'product',
    label: 'номер',
    type: 'number',
    imp: true,
    ml: 6
});
Invis.tools.form_append_field('change_quantity', {
	name:'count',
    label: 'количество',
    type: 'number',
    imp: true,
    ml: 1
});
Invis.tools.form_objects_draw("forms");

