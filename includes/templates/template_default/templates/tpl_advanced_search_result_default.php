<?php require(get_modules_file(FILENAME_PRODUCT_LISTING));?>

			<table  cellspacing="0" cellpadding="0" border="0" >
				<tr>
					<td>
						<h2 id="productListHeading"><?php echo $breadcrumb->last(); ?></h2>
					</td>
				</tr>          
				<?php if (count($tpl_products['products']) == 0):?>
					<tr>
					<td>
						<div>
							<b></b>
						</div>
					</td>
				</tr>          
				<?php else:?>
					<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
	<?php require(display_template('tpl_grid_display', 'common'));?>
					</td>
				</tr>
				<tr>
					<td>
						</td>
				</tr>          
				<?php endif;?>
			</table>
