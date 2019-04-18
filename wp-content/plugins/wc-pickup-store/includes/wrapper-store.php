<?php
/**
** $pid = $post->ID
** Override this template in /[theme]/template-parts/
**/
$waze_icon = apply_filters('wps_store_get_waze_icon', wps_store_get_waze_icon());
$store_full_image = get_the_post_thumbnail($pid, $attr['store_image_size']);
?>
<div class="<?= $class ?> widget_store-content" data-id="<?= $pid ?>">
	<?php if(!empty($store_image) && !empty($store_full_image)) : ?>
		<div class="parent-image-container">
			<div class="image-container">
				<?php echo $store_full_image; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if($attr['show_name']) : ?>
		<p class="store-title"><?php the_title() ?></p>
	<?php endif; ?>
	<?php echo !empty($city) ? '<p class="city">' . $city . '</p>' : ''; ?>
	<?php echo !empty($address) ? '<div class="address">' . apply_filters('the_content', $address) . '</div>' : ''; ?>
	<?php echo !empty($phone) ? '<p class="phone">' . $phone . '</p>' : ''; ?>
	<?php echo !empty($description) ? '<div class="description">' . apply_filters('the_content', $description) . '</div>' : ''; ?>
	<?php echo !empty($waze) ? '<p class="waze"><a href="' . $waze . '" target="_blank">' . $waze_icon . '</a></p>' : ''; ?>
</div>