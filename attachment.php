<?php get_header(); ?>
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
  <div class="post">
        <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
        <div class="galeribred">
        <div class="geriimaj">
			<?php previous_image_link( false, 'Previous Image' ); ?>
        </div>
        <div class="ileriimaj">
			<?php next_image_link( false, 'Sonraki resim' ); ?>
        </div>
    </div>
    
	<?php
	
		$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
	
		foreach ( $attachments as $k => $attachment ) {
	
			if ( $attachment->ID == $post->ID )
				break;
				
		}
	
		$k++;
	
		if ( count( $attachments ) > 1 ) {
	
			if ( isset( $attachments[ $k ] ) )
	
				$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
	
			else
	
				$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	
		} else {
	
			$next_attachment_url = wp_get_attachment_url();
	
		}

	?>
    <style type="text/css">
		#resim img {
			width: 100%;
			height: auto;	
		}
	</style>
	<a id="resim" href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment">
	<?php

		$attachment_size = apply_filters( 'fatihtoprak_attachment_size', 500 );
		echo wp_get_attachment_image( $post->ID, 'large' ); // Buyuk ebatlıyı bastır.

	?>
    </a>

		<div class="entry">
		<?php the_content(); ?>

		</div>

		<div class="galeribred" style="margin-top: 10px;">
        <div class="geriimaj">
			<?php previous_image_link( false, 'Previous Image' ); ?>
        </div>
		<div id="sayfalama2" style="margin-left: 15px; float: left; margin-top: 6px;">
			<?php
            /*Galeri Sayfalama*/ 
            $total_attach = count( $attachments);
            $big = 999999999;
            $gallery_nav = paginate_links( array( 'base' => str_replace( $big, '%#%', esc_url($big) ), 'format' => '%#%', 'current' => max( 1, $k ), 'total' => $total_attach, 'show_all' => false, 'end_size' => 2, 'mid_size' => 2, 'type'=>'array', 'prev_next'=>false ));
            $gallery_page_navi = '';

            foreach ($gallery_nav as $key => $value) {

                $gallery_page_navi .= preg_replace("(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)", get_attachment_link( $attachments[$key]->ID ), $value);

            }
            echo $gallery_page_navi;
            /*Galeri Sayfalama*/
            ?>

        </div>

		<div class="ileriimaj">
			<?php next_image_link( false, 'Sonraki resim' ); ?>
        </div>

</div>

		<div class="navigation-attachment">
		<style type="text/css">
		.page-numbers {
			border: solid 1px #ccc;
			background-color: #F2F2F2;
			padding: 5px;
			margin: 3px;
			font-weight: bold;
		}

		</style>
		<div id="sayfalama" style="position: absolute; margin-left: 120px; z-index: 9999;">

			<?php
            /*Galeri Sayfalama*/ 
            $total_attach = count( $attachments);
            $big = 999999999;
            $gallery_nav = paginate_links( array( 'base' => str_replace( $big, '%#%', esc_url($big) ), 'format' => '%#%', 'current' => max( 1, $k ), 'total' => $total_attach, 'show_all' => false, 'end_size' => 2, 'mid_size' => 2, 'type'=>'array', 'prev_next'=>false ));
            $gallery_page_navi = '';
            foreach ($gallery_nav as $key => $value) {
                $gallery_page_navi .= preg_replace("(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)", get_attachment_link( $attachments[$key]->ID ), $value);
            }
            echo $gallery_page_navi;
            /*Galeri Sayfalama*/
            ?>

        </div>

            <script type="text/javascript">

    		if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1);

			var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;

			if (is_chrome) {

				document.getElementById("sayfalama").style.top = "250px";

			}

    		</script>
            <style type="text/css">
			@-moz-document url-prefix() {
				#sayfalama {
					top: 250px;
				}
			}
			</style>


		</div>


	</div>
	<?php comments_template(); ?>
	<div class="navigation-links section">
		<span class="previous"><?php previous_post_link(); ?></span>
		<span class="next"><?php next_post_link(); ?></span>
	</div>
	<?php endwhile; ?>
<?php else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.','options'); ?></p>
<?php endif; ?>
<?php get_footer(); ?>
