<div class="modal-dialog modal-lg" id="image-manager">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
            <h4 class="modal-title">@Lang('admin::image.heading.title')</h4>
        </div>
        <div class="modal-body">
            <div class="modal-image-content">
                <div class="row">
                	{{-- 路径 --}}
					<div class="col-sm-12">
						<a class="btn btn-default" data-manager="load" href="{{ route('admin.image.index',['target'=>Request::get('target'),'thumb'=>Request::get('thumb')]) }}"  data-toggle="tooltip" title="@Lang('admin::image.button.back')"><i class="fa fa-level-up"></i></a>
						<a class="btn btn-default" role="button" href="{{ Request::get('directory')?route('admin.image.index',['directory'=>Request::get('directory'),'target'=>Request::get('target'),'thumb'=>Request::get('thumb')]):route('admin.image.index',['target'=>Request::get('target'),'thumb'=>Request::get('thumb')]) }}" id="button-refresh" data-toggle="tooltip" title="@Lang('admin::image.button.refresh')" data-manager="load" ><i class="fa fa-refresh"></i></a>
                        <a class="btn btn-warning" role="button" id="button-folder" type="button" data-toggle="tooltip" title="@Lang('admin::image.button.folder')"><i class="fa fa-folder-o"></i></a>
                        
                        <a class="btn btn-primary" role="button" id="button-upload" type="button"  data-toggle="tooltip" title="@Lang('admin::image.button.upload')"><i class="fa fa-upload"></i></a>
					</div>
        		</div>
        		<hr/>
				
        		{{-- 图片列表 --}}
        		@if($files)
	                @foreach(array_chunk($files->items(), 4) as $file)
	                <div class="row">
	                    @foreach($file as $value)
	                    @if($value['type']=='directory')
		                    <div class="col-sm-3 text-center image-manager">
		                    	<a class="thumbnail" href="{{ route('admin.image.index',['directory'=>$value['directory'],'target'=>Request::get('target'),'thumb'=>Request::get('thumb')]) }}" data-manager="load">
	                    			<i class="fa fa-folder fa-5x text-primary"></i>
	                    			<div class="text-ellipsis text-primary">{{ $value['name'] }}</div>
		                    	</a>
		                    	<a class="text-center image-manager-delete" href="" data-directory="{{ $value['directory'] }}" data-manager="delete"><i class="fa fa-trash-o fa-2x"></i></a>
		                    </div>
		                @elseif($value['type']=='image')
		                    <div class="col-sm-3 text-center image-manager">
		                        <a class="thumbnail data-manager-select" href="" data-manager="select" data-image-thumb="{{ $value['thumb'] }}" data-image-filename="{{ $value['filename'] }}">
		                            <img class="img-responsive" src="{{ $value['thumb'] }}" width="100px" height="100px" />
		                        </a>
		                        <a class="text-center image-manager-delete" href="" data-file="{{ $value['file'] }}" data-manager="delete"><i class="fa fa-trash-o fa-2x"></i></a>
		                    </div>
	                    @endif
	                    @endforeach
	                </div>
	                @endforeach
	            @else
	            	<div class="row">
	            		<h3 class="text-center">@Lang('admin::image.text.empty')</h3>
	            	</div>
	            @endif
            </div>
        </div>
        {{-- modal-body --}}
        <div class="modal-footer">
        	{{ $files->links() }}
        </div>{{-- modal-footer --}}
    </div>
    {{-- End modal-content --}}
</div>
<script>
{{-- 确认图片 --}}
$('#modal-image a[data-manager=select]').on('click', function(e) {
	e.preventDefault();
	$('#{{ Request::get('thumb') }}').find('img').attr('src', $(this).attr('data-image-thumb'));
	$('#{{ Request::get('target') }}').val($(this).attr('data-image-filename'));
	$('#modal-image').modal('hide');
});

{{-- End 确认图片 --}}
{{-- load --}}
$('#modal-image a[data-manager=load]').on('click', function(e) {
	e.preventDefault();
	
	$('#modal-image').load($(this).attr('href'));
});
{{-- End load --}}
{{-- pagination --}}
$('#modal-image .pagination a').on('click', function(e) {
	e.preventDefault();
	
	$('#modal-image').load($(this).attr('href'));
});
{{-- End pagination --}}
{{-- Delete --}}
$('#modal-image a[data-manager=delete]').on('click', function(e) {
	e.preventDefault();

	if(!confirm('@Lang('admin::image.confirm.delete')')){
		return;
	}
	
	var data = {};

	if($(this).attr('data-file')){
		data = {
			file:$(this).attr('data-file')
		};
	}
	else if($(this).attr('data-directory')){
		data = {
			directory:$(this).attr('data-directory')
		};
	}
	$.ajax({
		headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
		url: '{{ route('admin.image.delete') }}',
		type: 'post',		
		dataType: 'json',
		data: data,
		success: function(json) {
			// console.log(json);
			if (json['error']) {
				alert(json['error']);
			}
			if (json['success']) {
				alert(json['success']);
									
				$('#modal-image #button-refresh').trigger('click');
			}
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
{{-- End Delete --}}
{{-- Upload --}}
$('#modal-image #button-upload').on('click', function() {
	
	$('#form-upload').remove();
	
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" value=""  multiple="multiple" accept="image/*"/></form>');
	
	$('#form-upload input[name=\'file[]\']').trigger('click');
	
	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file[]\']').val() != '') {
			clearInterval(timer);
			
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: '{{ Request::get('directory')?route('admin.image.upload',['directory'=>Request::get('directory')]):route('admin.image.upload') }}',
				type: 'post',		
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,		
				beforeSend: function() {
					$('#modal-image #button-upload i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
					$('#modal-image #button-upload').prop('disabled', true);
				},
				complete: function() {
					$('#modal-image #button-upload i').replaceWith('<i class="fa fa-upload"></i>');
					$('#modal-image #button-upload').prop('disabled', false);
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}
					
					if (json['success']) {
						alert(json['success']);
						$('#modal-image #button-refresh').trigger('click');
					}
				},			
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});	
		}
	}, 500);
});
{{-- End Upload --}}
{{-- Folder --}}
$('#modal-image #button-folder').popover({
	html: true,
	placement: 'bottom',
	trigger: 'click',
	title: '@Lang('admin::image.heading.folder')',
	content: function() {
		html  = '<div class="input-group">';
		html += '  <input type="text" name="folder" value="" placeholder="@Lang('admin::image.form.folder')" class="form-control">';
		html += '  <input type="hidden" name="directory" value="{{ Request::get('directory') }}">';
		html += '  <span class="input-group-btn"><button type="button" title="@Lang('admin::image.button.folder')"  id="button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>';
		html += '</div>';
		
		return html;	
	}
});

$('#modal-image #button-folder').on('shown.bs.popover', function() {
	$('#modal-image #button-create').on('click', function() {
		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
			url: '{{ route('admin.image.folder') }}',
			type: 'post',		
			dataType: 'json',
			data: {
				folder:$('input[name=\'folder\']').val(),
				directory:$('input[name=\'directory\']').val(),
			},
			beforeSend: function() {
				$('#modal-image #button-create').prop('disabled', true);
			},
			complete: function() {
				$('#modal-image #button-create').prop('disabled', false);
			},
			success: function(json) {
				// console.log(json);
				if (json['error']) {
					alert(json['error']);
				}
				if (json['success']) {
					alert(json['success']);
										
					$('#modal-image #button-refresh').trigger('click');
				}
			},			
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});	
});
{{-- End Folder --}}

</script>