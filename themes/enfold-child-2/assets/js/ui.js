jQuery(document).ready($ => {

//////////////
// RV Space //
//////////////

const $nameFieldRV = $('.product_cat-rv-spaces').find('.product-addon-attendee, .product-addon-rv-alias').children('p.form-row')
const $shirtFieldRV = $('.product_cat-rv-spaces .product-addon-shirt-size select option:first-child')

$nameFieldRV.each( (idx, el) => {
	const $el = $(el)
	const label = $el.children('label').text()
	$el.children('input').attr('placeholder', label.trim());
})

$shirtFieldRV.prop('disabled', true).text('Select shirt size...')

////////////
// Ticket //
////////////

const $nameFieldTick = $('.product_cat-tickets .wccpf-fields-container').find('.first_name-wrapper, .last_name-wrapper')
const $shirtFieldTick = $('.product_cat-tickets .wccpf-fields-container select option:first-child')

$nameFieldTick.each( (idx, el) => {
	const $el = $(el)
	const label = $el.find('.wccpf_label').children('label').text()
	console.log(label)
	$el.find('input').attr('placeholder', label.trim());
})

$shirtFieldTick.prop('disabled', true)

})
