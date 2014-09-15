<?php
function getCalculatorFiled() {
	return array(
		array(
			'label' => 'Leave Date',
			'name'  => 'leave-date',
			'type'  => 'text',
			'class' => 'calculator-type-datepicker calculate-required'
		),
		array(
			'label' => 'Back Date',
			'name'  => 'back-date',
			'type'  => 'text',
			'class' => 'calculator-type-datepicker calculate-required'
		),
		array(
			'label'   => 'Inspection Every',
			'name'    => 'inspection-times',
			'type'    => 'select',
			'options' => array(
				'1' => '1 Day',
				'2' => '2 Day',
				'3' => '3 Day',
				'4' => '4 Day',
			),
			'class'   => 'calculator-inspection-dropdown calculate-required'
		),
		array(
			'label' => 'Senior Citizen',
			'name'  => 'senior-check',
			'type'  => 'checkbox',
			'value' => '1',
			'class' => 'calculator-seniro-checkbox calculate-required'
		),

	);
}


?>
<h3>Order</h3>
<table class="table table-bordered">
	<thead>
		<tr>

		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Service Per Time:</td>
			<td><?php echo $product->get_price_html(); ?>        </td>
		</tr>
		<?php $fields = getCalculatorFiled();
		foreach ( $fields as $field ):?>
			<tr>
				<td><?php echo $field['label']; ?></td>
				<td>
					<?php switch ( $field['type'] ) {
						case 'select':
							?>
							<select id="calculator-<?php echo $field['name'] ?>" class="<?php echo $field['class']; ?>" name="<?php echo $field['name'] ?>">
								<?php foreach ( $field['options'] as $value => $option ): ?>
									<option value="<?php echo $value; ?>"><?php echo $option; ?></option>
								<?php endforeach; ?>
							</select>
							<?php
							break;

						default:
							printf( '<input type="%s" id="%s" name="%s" class="%s">', $field['type'], 'calculator-' . $field['name'], $field['name'], $field['class'] );

					} ?>
				</td>
			</tr>
		<?php endforeach; ?>

		<tr>
			<td><?php echo __( 'Number of packs:', 'wqc' ); ?></td>
			<td><input type="text" value="" name="quantity" id="quantity_product_input" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">
				<button type="submit" class="button alt">
					<?php echo apply_filters( 'single_add_to_cart_text', __( 'Add to cart', 'woocommerce' ), $product->product_type ); ?>
				</button>
			</td>
		</tr>
	</tbody>
</table>
