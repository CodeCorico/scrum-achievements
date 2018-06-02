<?php get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
			$loop = new WP_Query(array(
				'post_type' => 'succes',
				'posts_per_page' => 10,
				'meta_key' => 'success_categories',
				'orderby' => 'meta_value',
				'order' => 'ASC',
			));

			$lastCategory = '';

			while ( $loop->have_posts() ) :
				$loop->the_post();

				$id = absint(get_the_ID());

				$categories = get_field('success_categories');
				$categoryCSS = '';
				$categoryName = '';

				if (is_array($categories) && count($categories) > 0) {
					$categoryCSS = $categories[0]->description;
					$categoryName = $categories[0]->name;
				}

				$rewardPercent = 0;

				$hasReward = !!badgeos_get_user_achievements(array('achievement_id' => $id));

				if ($hasReward) {
					$rewardPercent = 100;
				}
				else {
					$stepsHTML = badgeos_get_required_achievements_for_achievement_list();

					if ($stepsHTML) {
						$total = preg_match_all('/<li/', $stepsHTML);

						if ($total && $total > 0) {
							$count = preg_match_all('/user-has-earned/', $stepsHTML);
							$rewardPercent = round($count * 100 / $total);
						}
					}
				}

				$earners = badgeos_get_achievement_earners_list($id);
		?>

		<?php
			if ($categoryName != $lastCategory) {
				$lastCategory = $categoryName;
		?>

		<h2 class="succes-category-title"><?php echo $lastCategory; ?></h2>

		<?php } ?>

		<?php for ($i = 0; $i < 8; $i++) { ?>

		<?php /* style="<?php echo $categoryCSS; ?>" */ ?>

		<div
			class="succes-post <?php echo ($rewardPercent > 0 ? 'has-percent' : ''); ?>"
			href="<?php the_permalink(); ?>"
			style="<?php echo $categoryCSS; ?>"
		>
			<div class="succes-post-content">
				<?php the_post_thumbnail(); ?>

				<h1><?php the_title(); ?></h1>

				<?php the_excerpt(); ?>
				<?php if ($earners) { ?>
					<div class="succes-post-earners">
						<i class="dashicons dashicons-awards" aria-hidden="true"></i>
						<?php echo $earners; ?>
					</div>
				<?php } ?>
			</div>

			<?php if ($rewardPercent > 0) { ?>
				<div class="succes-post-percent <?php echo ($hasReward ? 'has-reward' : ''); ?>">
					<i class="dashicons dashicons-awards" aria-hidden="true"></i>
					<?php if ($hasReward) { ?>
					<?php } else { ?>
						<span><?php echo $rewardPercent; ?>%</span>
					<?php } ?>
				</div>
			<?php } ?>

			<a class="succes-post-link" href="<?php the_permalink(); ?>"></a>
		</div>

		<?php } ?>

		<?php
			endwhile;
		?>

	</main>
</div>

<?php
get_footer();
