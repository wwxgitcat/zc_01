<?php
/**
* Template designed by 12leaves.com
* 12leaves.com - Free ecommerce templates and design services
*
 * @copyright Copyright 2009-2010 12leaves.com
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
$content = "";
$product_amount = 0;

if ($_SESSION['cart']->count_contents() > 0)
{
	$products = $_SESSION['cart']->get_products();
	
	for($i = 0, $n = sizeof($products); $i < $n; $i++)
	{
		$product_amount = $products[$i]['quantity'] + $product_amount;
	}

	$content .= ' <a title="My Cart" target="_top" class="top-link-cart" href="' . zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL') . '">&nbsp;<span style="color: #d8272d">' . $product_amount . '</span>&nbsp;'  . 'item(s)&nbsp;-&nbsp;';

	?>

                                        <div id="itemsInCartNotifier" class="notifier" >
											<div id="orderitemcount" onmouseout="mclosetime()" onmouseover="mopen('macart')" style="cursor:pointer" >
												<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>">
                                        
												<?php echo TEXT_TOTAL_ITEMS.$_SESSION['cart']->count_contents() . ' ' . '';?></a>
											</div>
							

                                        <div  onmouseout="mclosetime()" onmouseover="mcancelclosetime()" id="macart" style="">
                                            <!-- JSP for showing the Mini Bag content in the header part -->
                                            <!-- <div class="mini-cart-caps"></div> -->
                                            <div id="miniCartItems">
                                                <div class="CartItems_head_tit">
                                                   
                                                </div>
                                                <p id="orderCount">
                                              &nbsp;
                                                    <span>
                                                      <?php echo CART_ITEMS.$product_amount;?>
                                                    </span>
              
                                                </p>
                                                <div id="miniCartItems_scroll">

												<?php foreach($products as $product){?>
                                                    <div class="mini-cart-item">
                                                        <div class="mini-cart-item-image">
															<?php
																	$productsImage = (IMAGE_SHOPPING_CART_STATUS == 1 ? zen_image(DIR_WS_IMAGES . $product['image'], $product['name'], IMAGE_SHOPPING_CART_WIDTH, IMAGE_SHOPPING_CART_HEIGHT) : '');
																echo $productsImage; 
																?>
                                                        </div>
                                                        <div class="mini-cart-item-details">
                                                            <span class="cart-product-name">
                                                                <?php echo $product['name']; ?>
                                                            </span>
															<?php
																	/*
															if (isset($product['attributes']) && is_array($product['attributes']))
															{
																echo '<div class="cartAttribsList">';
																reset($product['attributes']);
																foreach($product['attributes'] as $option => $value)
																{
																

																	 <div class="mini-cart-item-line">
																	 <span class="mini-cart-item-value">
																		<?php echo ''. nl2br($value['products_options_values_name']);
																	 </span></div>

																
																}
																echo '</div>';
															}*/
															?>
                                                            <div class="mini-cart-item-line">
                                                                <span class="mini-cart-item-label">
                                                                    <?PHP echo TABLE_HEADING_QUANTITY;?>:&nbsp;
                                                                </span>
                                                                <span class="mini-cart-item-value">
																		<?php echo $product['quantity'];?>
                                                                </span>
                                                            </div>
                                                            <div class="mini-cart-item-price">
																	 <?PHP echo TABLE_HEADING_PRICE;?>:&nbsp;<?php echo  $currencies->format($product['final_price']); ?>
																
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
														<?php
															} // end foreach ($productArray as $product)
														?>
                                                </div>
                                            </div>
                                            <div class="mini-cart-subtotal">
                                                <span class="subtotals">
                                                  <?php echo SUB_TITLE_SUB_TOTAL; ?>
                                                </span>
                                                <?php echo $currencies->format($_SESSION['cart']->show_total()); ?>
                                            </div>
                                            <div class="mini-cart-buttons">
                                                <a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>">
                                                    <button class="alt-button mini-cart-view-bag" title="View Bag">
                                                       <?php echo BOX_HEADING_SHOPPING_CART; ?>
                                                    </button>
                                                </a>
												<a href="<?php zlink('checkout_confirmation'); ?>">
													<button class="alt-button mini-cart-view-bag" title="Checkout">
														   <?php echo PAGE_CHECKOUT_SHIPPING; ?>
													</button>
												</a>
                                            </div>
                                            <div class="mini-cart-caps">
                                            </div>
                                        </div>
			</div>
<?php
}
else
{
?>
								<div id="itemsInCartNotifier" class="notifier"><div id="orderitemcount"><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>">
                                        
                                        <?php echo TEXT_TOTAL_ITEMS.$_SESSION['cart']->count_contents() . ' ';?></a></div></div>
                                
                                <!--
                                        <div id="miniCartContiainer">
                                            <div id="miniCartItems">
                                                <div class="CartItems_head_tit">
                                                    Shopping Bag
                                                </div>
                                                <p id="orderCount">
                                                    You have&nbsp;
                                                    <span>
                                                        0
                                                    </span>
                                                    items in your Shopping Bag.
                                                </p>
                                                <div id="miniCartItems_scroll">
                                                </div>
                                            </div>
                                            <div class="mini-cart-subtotal">
                                            </div>
                                            <div class="mini-cart-buttons">
                                                <a href="<?php zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL') ?>">
                                                    <button class="alt-button mini-cart-view-bag" title="View Bag">
                                                        View Full Cart
                                                    </button>
                                                </a>
                                            </div>
                                            <div class="mini-cart-caps">
                                            </div>
                                        </div>-->

<?php } ?>


