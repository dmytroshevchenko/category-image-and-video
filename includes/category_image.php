<?php

add_action( 'category_add_form_fields', 'add_category_image', 10, 2 );
function add_category_image ( $taxonomy ) { ?>

	<div class="form-field term-image-wrap">
		<label for="tag-slug">Image</label>
		<input type="hidden" id="category_image_id" name="category_image_id" value="">
		<div id="category_image_block"></div>
		<p>
			<button class="button button-secondary add_category_image" id="add_category_image">Add Image</button>
			<button class="button button-secondary remove_category_image" id="remove_category_image">Remove Image</button>
		</p>
	</div>

<?php
}

add_action( 'created_category', 'save_category_image', 10, 2 );
function save_category_image ( $term_id, $tt_id ) {
	if( isset( $_POST['category_image_id'] ) && '' !== $_POST['category_image_id'] ){
		$image = $_POST['category_image_id'];
		add_term_meta( $term_id, 'category_image_id', $image, true );
	}
}

add_action( 'category_edit_form_fields', 'update_category_image', 10, 2 );
function update_category_image ( $term, $taxonomy ) { ?>

	<tr class="form-field term-slug-wrap">
		<th scope="row">
			<label for="tag-slug">Image</label>
		</th>
		<td>
			<?php $image_id = get_metadata('term', $term->term_id, 'category_image_id')[0]; ?>
			<div class="category_image_block" id="category_image_block">
				<?php if ( $image_id ) { ?>
					<?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
				<?php } ?>
	       </div>
	       <input type="hidden" id="category_image_id" name="category_image_id" value="<?php echo $image_id; ?>">
	       <p>
				<button class="button button-secondary add_category_image" id="add_category_image">Add Image</button>
				<button class="button button-secondary remove_category_image" id="remove_category_image">Remove Image</button>
			</p>
	   </td>
	</tr>

 <?php
 }

add_action( 'edited_category', 'updated_category_image', 10, 2 );
function updated_category_image ( $term_id, $tt_id ) {
	if( isset( $_POST['category_image_id'] ) && '' !== $_POST['category_image_id'] ){
		$image = $_POST['category_image_id'];
		update_term_meta ( $term_id, 'category_image_id', $image );
	} else {
		update_term_meta ( $term_id, 'category_image_id', '' );
	}
}






?>