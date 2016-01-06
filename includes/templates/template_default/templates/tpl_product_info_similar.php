
<div id="contents">
<div class="search-result-content isotope">
<div id="isotope-container" class="isotope-container">
   <div id="search-result-items" class="search-result-items tiles-container clearfix ">
        <h5 id="YouMightToggle">
         Sie können auch gerne

        </h5>
   
				<?php $ccnum=1; $col = 0;$col2 = 0;foreach ($tpl_products['products'] as $product):?>
					 <?php $col++;?>
					<?php $col2++;?>
					<?php if ($col==1 ):?>
					<?php endif;?>	



 <div class="grid-tile ">

<div class="product-tile" itemtype="http://schema.org/Product" itemscope="" data-itemid="5815S">
<div class="product-image" itemprop="image">
									<a id="crossSells"  iclass="youmight" class="product_img_link"  href="<?php echo $product['href'];?>" title="<?php echo $product['name'];?>">
											<?php echo zen_image(DIR_WS_IMAGES.$product['image'], $product['name'], 220, 220,'tabindex="36"');?>
									</a>
                                    
                                    
                                    </div>
                                    
                                    
                                    
                                <div class="product-name" itemprop="name">
<h2>


										<a tabindex="36" class="product-name"  href="<?php echo $product['href'];?>" title="<?php echo $product['name'];?>"><?php echo safe_cut_str($product['name'],155,'...');?></a></h2></div>
                                        
                                        
                                        
                                        
									<h4>
										<strike>
											<div class="strike_price">
																<?php if (!empty($product['display_normal_price'])):?>
																	<?php echo $product['display_normal_price'];?>
																<?php endif;?>
													</div>
										</strike>
                                        
                                        
											<div class="display_price PriceRed">
																<?php if (!empty($product['display_special_price'])):?>
																	<?php echo $product['display_special_price'];?>
																<?php endif;?>
																&nbsp;&nbsp;&nbsp;
																<?php if (!empty($product['display_sale_price'])):?>
																	<?php echo $product['display_sale_price'];?>
																<?php endif;?>
										</div>
									</h4>
                                    <div class="item-details">
                                    </div>
                                    
                                    
                                     <div itemtype="http://schema.org/Review" itemscope="" itemprop="reviews" class="review">



<div class="pr-snippet-stars">
<div itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating" class="product_rating stars-10"></div>
<span class="pr-snippet-rating-decimal pr-rounded">5.0</span>
</div>


</div>
                                    
                                    
                                    
                                    
                                    </div>
                                </div>
                                
                                
                                

					<?php if ($col>4):?>
					<?php $col = 0;?>
						<?php  echo '<br class="clear"/>';?>		
					<?php endif;?>
					<?php endforeach;?>
					<?php if ($col2%5!=0):?>
					<?php  echo '<br class="clear"/>';?>		
					<?php endif;?>
     
    </div>
    </div>
    </div>
</div>

