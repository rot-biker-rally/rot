jQuery(document).ready($ => {

const $nameField = $('.product_cat-rv-spaces .bundled_item_cart_details .product-addon-attendee p.form-row')
const $shirtField = $('.product_cat-rv-spaces .bundled_item_cart_details .product-addon-shirt-size select option:first-child')

$nameField.each( (idx, el) => {
	const $el = $(el)
	const label = $el.children('label').text()
	$el.children('input').attr('placeholder', label.trim());
})

$shirtField.prop('disabled', true).text('Select shirt size...')

})
