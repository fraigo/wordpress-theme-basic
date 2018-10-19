<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Demo
 * @since Demo 1.0
 */
?>
				</div>
			</div>
		</div>
	</div><!-- .site-content -->

  <footer class="footer">
      <div class="container">
				<div class="site-info">
				<?php
					
					do_action( 'demo_credits' );
				?>
				<?php
				if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
				}
				?>
				<a href="<?php echo esc_url( __( 'https://franciscoigor.me/', 'demo' ) ); ?>" class="imprint">
					<?php printf( __( 'Proudly powered by %s', 'demo' ), 'Francisco Igor' ); ?>
				</a>
			</div><!-- .site-info -->
      </div>
    </footer>

<?php wp_footer(); ?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/popper.min.js" ></script>
<script src="https://getbootstrap.com/docs/4.1/dist/js/bootstrap.min.js" ></script>

</body>
</html>
