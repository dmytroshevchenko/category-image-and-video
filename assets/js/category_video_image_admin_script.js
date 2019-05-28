(function($) {

	$(document).on('click', '#add_category_image', function(e) {
		e.preventDefault();
		var button = $(this);
		wp.media.editor.send.attachment = function(props, attachment) {
			$('#category_image_block').html('<img src=' + attachment.sizes.thumbnail.url + '>');
			$('#category_image_id').val(attachment.id);
		}
		wp.media.editor.open(button);
		return false;
	});

	$(document).on('click', '#remove_category_image', function(e) {
		e.preventDefault();
		$('#category_image_block').html('');
		$('#category_image_id').val('');
		return false;
	});


	$(document).on('click', '#add_category_video', function(e) {
		e.preventDefault();
		var button = $(this);
		wp.media.editor.send.attachment = function(props, attachment) {
			$('#category_video_url').val(attachment.url);
			show_video( attachment.url );
		}
		wp.media.editor.open(button);
		$('#media-attachment-filters').find('option[value="video"]').attr('selected', 'selected')
		$('#media-attachment-filters').trigger('change')
		return false;
	});

	$(document).on('keyup', '#category_video_url', function(e) {
		show_video( $(this).val() );
	});


	function show_video( category_video_url ){

		var ajaxurl = '/wp-admin/admin-ajax.php';

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			dataType: 'json',
			data: {
				'action' : 'show_video',
				'category_video_url' : category_video_url
			},
			beforeSend:function() {
				$('#category_video_block').html('');
				$('.category_video_block .preloader').slideDown();
			},
			success: function(data) {
				$('#category_video_block').html( data.data.video );
				$('.category_video_block .preloader').hide();

				if( $('#category_video_block').find('video').length ){
					$('#category_video_block').find('video').attr('preload', 'auto')
				}
			},
			error: function(){
				console.log('error');
			},
		});
	}



	$(document).on('click', '#remove_category_video', function(e) {
		e.preventDefault();
		$('#category_video_block').html('');
		$('#category_video_url').val('');
		return false;
	});



})( jQuery );