<div class="staff-grid__item">
	<a href="javascript:void(0)" class="staff-grid__trigger">
		<div class="staff-grid__photo"><?php the_post_thumbnail('medium'); ?></div>
		<h3 class="staff-grid__name"><?php the_title(); ?></h3>

		<?php if ( class_exists('ACF') && get_field('kms_job_title') ) : ?>
			<p class="staff-grid__title"><?php the_field('kms_job_title'); ?></p>
		<?php endif; ?>

	</a>
	<div class="staff-grid__content">
		<button class="staff-grid__content__close"><?php esc_html_e( 'Close', 'km-staff' ); ?></button>
		<h4 class="staff-grid__content__name"><?php the_title(); ?></h4>

		<?php if ( class_exists('ACF') && get_field('kms_job_title') ) : ?>
			<p class="staff-grid__content__title"><?php the_field('kms_job_title'); ?></p>
		<?php endif; ?>

		<div class="staff-grid__content__bio"><?php the_content(); ?></div>
	</div>
</div>
