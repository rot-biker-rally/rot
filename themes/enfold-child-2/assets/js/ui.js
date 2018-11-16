jQuery(document).ready($ => {

//////////////
// RV Space //
//////////////

const $nameFieldRV = $('.product_cat-rv-spaces .bundled_item_cart_details .product-addon-attendee p.form-row')
const $shirtFieldRV = $('.product_cat-rv-spaces .bundled_item_cart_details .product-addon-shirt-size select option:first-child')

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

$nameFieldTick.each( (idx, el) => {
	const $el = $(el)
	const label = $el.find('.wccpf_label').children('label').text()
	console.log(label)
	$el.find('input').attr('placeholder', label.trim());
})

})
