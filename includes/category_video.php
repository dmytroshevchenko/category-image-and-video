<?php

add_action( 'category_add_form_fields', 'add_category_video', 10, 2 );
function add_category_video ( $taxonomy ) { ?>

	<div class="form-field term-image-wrap video_input_block">
		<label for="tag-slug">Video</label>
		<input type="text" id="category_video_url" name="category_video_url" value="">
		<button class="button button-secondary add_category_video" id="add_category_video">Open media</button>

		<div class="category_video_block">
			<div class="preloader"><img src="<?php echo CATEGORY_PLUGIN_URL.'/assets/images/loader.gif'; ?>"></div>
			<div id="category_video_block"></div>
		</div>
		
	</div>

<?php
}

add_action( 'created_category', 'save_category_video', 10, 2 );
function save_category_video ( $term_id, $tt_id ) {
	if( isset( $_POST['category_video_url'] ) && '' !== $_POST['category_video_url'] ){
		$image = $_POST['category_video_url'];
		add_term_meta( $term_id, 'category_video_url', $image, true );
	}
}

add_action( 'category_edit_form_fields', 'update_category_video', 10, 2 );
function update_category_video ( $term, $taxonomy ) { ?>

	<?php $video_url = get_metadata('term', $term->term_id, 'category_video_url')[0]; ?>
	<tr class="form-field term-slug-wrap">
		<th scope="row">
			<label for="tag-slug">Video</label>
		</th>
		<td>
			<div class="video_input_block">
				<input type="text" id="category_video_url" name="category_video_url" class="category_video_input" value="<?php echo $video_url; ?>">
				<button class="button button-secondary add_category_video" id="add_category_video">Open media</button>
				<button class="button button-secondary remove_category_video" id="remove_category_video">X</button>
			</div>
			<p class="description">
				Paste video-link here, or choose from media-files 
			</p>

			<div class="category_video_block">
				<div class="preloader"><img src="<?php echo CATEGORY_PLUGIN_URL.'/assets/images/loader.gif'; ?>"></div>
				<div id="category_video_block">
					<?php if ( $video_url ) {
						echo apply_filters('the_content', $video_url);
					} ?>
				</div>
			</div>
	   </td>
	</tr>

 <?php
 }

add_action( 'edited_category', 'updated_category_video', 10, 2 );
function updated_category_video ( $term_id, $tt_id ) {
	if( isset( $_POST['category_video_url'] ) && '' !== $_POST['category_video_url'] ){
		$image = $_POST['category_video_url'];
		update_term_meta ( $term_id, 'category_video_url', $image );
	} else {
		update_term_meta ( $term_id, 'category_video_url', '' );
	}
}





add_action('wp_ajax_nopriv_show_video', 'show_video');
add_action('wp_ajax_show_video', 'show_video');


if (!function_exists('show_video')) {
	function show_video() {

		$category_video_url = $_POST['category_video_url'];
		$html = apply_filters('the_content', $category_video_url);
		wp_send_json_success(
			array(
				'video' => $html,
			)
		);

	}
}




?>