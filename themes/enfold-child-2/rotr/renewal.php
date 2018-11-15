<?php
$err = null;
$rkey = $_GET['rk'] ?? null;
$cf = get_fields();

function get_spots( $rkey, $cf ) {
	if ( $rkey == null ) {
		return array( $cf['err_no_key'], null );
	} else {
		$spots = wc_get_products( array( 'renew-key' => $rkey ) );
		if ( count( $spots ) < 1 ) {
			return array( $cf[err_bad_key], null );
		} else {
			$stock = array_sum(array_map( function ( $x ) { return $x->get_stock_quantity(); }, $spots ));
			if ( $stock < 1 ) {
				return array( $cf[err_spent_key], null );
			} else {
				return array( null, $spots );
			}
		}
	}
}
list( $err, $spots ) = get_spots( $rkey, $cf );

if ( $err ): ?>
	<h2 class="renew-err"><?=$err?></h2>
	<?php
else:
	$skus = array();
	foreach ($spots as $s) {
		$skus[] = $s->get_sku();
	}
	global $post; ?>
	<div class="renewal-hed-dek">
		<h1><?=$cf['hed']?></h1>
		<h2><?=$spots[0]->get_meta('renew-fname').' '.$spots[0]->get_meta('renew-lname')?></h2>
	</div>
	<script>var points=<?=rotr\spots_prep( rotr\spots_retrieve() )?></script>
	<script>var pointsHot=<?=json_encode($skus)?></script>
	<script>var rkey='<?=$rkey?>'</script>
	<div id="map"></div>
	<?php foreach ( $spots as $s ): ?>
		<div class="renew-spot">
		<?php
		$post = get_post( $s->get_id() );
		setup_postdata( $post ); ?>
		<h3>Space <?=$s->get_sku()?></h2>
		<?php wc_get_template_part( 'single', 'product/price' ); ?>
		<table class="shop_attributes">
			<tr><th>Lot:</th><td><?=$s->get_attribute('lot')?></td></tr>
			<tr><th>Old Space Number:</th><td><?=$s->get_meta('locid-old')?></td></tr>
		</table>
		<?php if ( $s->get_stock_quantity() > 0 ) : ?>
			<a class="button" href="<?=$s->get_permalink()."?rk=$rkey"?>" target="_blank">Renew Now</a>
		<?php else: ?>
			<button class="button" disabled>Already Renewed</button>
		<?php endif; ?>
		</div>
		<?php
	endforeach;
endif;
