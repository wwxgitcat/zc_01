<?php require(get_modules_file('checkout_address_book'));?>

<?php while(!$addresses->EOF){?>
<div class="col-xs-12 col-sm-6 col-md-6" <?php if ($addresses->fields['address_book_id'] == $_SESSION['sendto']){ echo 'id="defaultSelected" class="moduleRowSelected"';}else{echo 'class="moduleRow"';}?>>
	<label class="radio" for="name-<?php echo $addresses->fields['address_book_id']; ?>">
		<?php echo zen_draw_radio_field('address', $addresses->fields['address_book_id'], ($addresses->fields['address_book_id'] == $_SESSION['sendto']), 'id="name-' . $addresses->fields['address_book_id'] . '"'); ?>
		<?php echo zen_output_string_protected($addresses->fields['firstname'] . ' ' . $addresses->fields['lastname']); ?>
	</label>
	<address><?php echo zen_address_format(zen_get_address_format_id($addresses->fields['country_id']), $addresses->fields, true, ' ', '<br />'); ?></address>
</div>
<?php $addresses->MoveNext();
}
?>