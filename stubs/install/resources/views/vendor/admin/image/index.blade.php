<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                ×
            </button>
            <h4 class="modal-title">
                @Lang('admin::image.heading.title')
            </h4>
        </div>
        <div class="modal-body">
            <div class="modal-image-content">
                <div class="row">
                	{{-- 路径 --}}
					<div class="col-sm-5">
						<ul class="breadcrumb" style="line-height:34px;">
							<li></li>
							<li><a href="{{ route('admin.image.index',['target'=>Request::get('target'),'thumb'=>Request::get('thumb')]) }}" data-manager="load" >image</a></li>
							@if(Request::get('directory'))
							<li><a href="{{ route('admin.image.index',['directory'=>Request::get('directory'),'target'=>Request::get('target'),'thumb'=>Request::get('thumb')]) }}" data-manager="load" >{{ Request::get('directory') }}</a></li>
							@endif
						</ul>
					</div>
					{{-- END 路径 --}}
                    <div class="col-sm-7 text-right">
                    	
                    	<a class="btn btn-info" role="button" data-toggle="collapse" href="#collapsefolders" aria-expanded="false" aria-controls="collapsefolders" >
                        	<i class="fa fa-folder"></i> @Lang('admin::image.text.folders')
                        </a>
                        @if(!Request::get('directory'))
                        <a class="btn btn-warning" role="button" id="button-folder" type="button">
                            <i class="fa fa-folder-o"></i> @Lang('admin::image.button.folder')
                        </a>
                        @else
                        <a class="btn btn-warning" data-manager="load" href="{{ route('admin.image.index',['target'=>Request::get('target'),'thumb'=>Request::get('thumb')]) }}">
                            <i class="fa fa-reply"></i> @Lang('admin::image.button.back')
                        </a>
                        @endif
                        <a class="btn btn-primary" role="button" id="button-upload" type="button">
                            <i class="fa fa-upload"></i> @Lang('admin::image.button.upload')
                        </a>
                        <a class="btn btn-info" role="button" href="{{ Request::get('directory')?route('admin.image.index',['directory'=>Request::get('directory'),'target'=>Request::get('target'),'thumb'=>Request::get('thumb')]):route('admin.image.index',['target'=>Request::get('target'),'thumb'=>Request::get('thumb')]) }}" id="button-refresh" title="" data-manager="load">
                            <i class="fa fa-refresh"></i> @Lang('admin::image.button.refresh')
                        </a>
                        
                       
                        
                    </div>
        		</div>
        		<hr/>
        		
        		{{-- 目录列表 --}}
				<div class="collapse" id="collapsefolders">
					<div class="well clearfix">
						@if($directories)
							@foreach($directories as $value)
		                    <div class="col-sm-2 text-center">
		                    	<div class="thumbnail action directory">
	                    			<i class="fa fa-folder fa-5x text-primary"></i>
	                    			<div class="text-ellipsis text-primary">{{ $value }}</div>
		                    		<div class="block">
		                            	<div>
			                            	<a class="text-center" href="{{ route('admin.image.index',['directory'=>$value,'target'=>Request::get('target'),'thumb'=>Request::get('thumb')]) }}" data-manager="load">
			                            		<p><i class="fa fa-check fa-2x"></i></p>
			                            		@Lang('admin::image.button.select')
			                            	</a>
		                            	</div>
		                            	<div>
			                            	<a class="text-center" data-directory="{{ $value }}" data-manager="delete">
			                            		<p><i class="fa fa-trash-o fa-2x"></i></p>
			                            		@Lang('admin::image.button.delete')
			                            	</a>
		                            	</div>
		                            </div>
		                    	</div>
		                    </div>
		                    @endforeach
		                @else
		            		<h3 class="text-center">@Lang('admin::image.text.empty_directory')</h3>
		                @endif
					</div>
					<hr/>
				</div>
				
        		{{-- 图片列表 --}}
        		@if($files)
	                @foreach(array_chunk($files, 6) as $file)
	                <div class="row">
	                    @foreach($file as $value)
	                    <div class="col-sm-2 text-center">
	                        <div class="thumbnail action">
	                            <img class="img-responsive" src="{{ $value['thumb'] }}" width="100px" height="100px" />
	                            <div class="block">
	                            	<div>
		                            	<a class="text-center" href="" data-manager="image" data-image-thumb="{{ $value['thumb'] }}" data-image-filename="{{ $value['filename'] }}">
		                            		<p><i class="fa fa-check fa-2x"></i></p>
		                            		@Lang('admin::image.button.select')
		                            	</a>
	                            	</div>
	                            	<div>
		                            	<a class="text-center" href="" data-file="{{ $value['file'] }}" data-manager="delete">
		                            		<p><i class="fa fa-trash-o fa-2x"></i></p>
		                            		@Lang('admin::image.button.delete')
		                            	</a>
	                            	</div>
	                            </div>
	                        </div>
	                    </div>
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
    </div>
    {{-- End modal-content --}}
</div>
<script>
{{-- 确认图片 --}}
$('a[data-manager=image]').on('click', function(e) {
	e.preventDefault();
	$('#{{ Request::get('thumb') }}').find('img').attr('src', $(this).attr('data-image-thumb'));
	$('#{{ Request::get('target') }}').val($(this).attr('data-image-filename'));
	$('#modal-image').modal('hide');
});

{{-- End 确认图片 --}}
{{-- load --}}
$('a[data-manager=load]').on('click', function(e) {
	e.preventDefault();
	
	$('#modal-image').load($(this).attr('href'));
});
{{-- End load --}}
{{-- Delete --}}
$('a[data-manager=delete]').on('click', function(e) {
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
									
				$('#button-refresh').trigger('click');
			}
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
{{-- End Delete --}}
{{-- Upload --}}
$('#button-upload').on('click', function() {
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
					$('#button-upload i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
					$('#button-upload').prop('disabled', true);
				},
				complete: function() {
					$('#button-upload i').replaceWith('<i class="fa fa-upload"></i>');
					$('#button-upload').prop('disabled', false);
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}
					
					if (json['success']) {
						alert(json['success']);
						$('#button-refresh').trigger('click');
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
$('#button-folder').popover({
	html: true,
	placement: 'bottom',
	trigger: 'click',
	title: '@Lang('admin::image.heading.folder')',
	content: function() {
		html  = '<div class="input-group">';
		html += '  <input type="text" name="folder" value="" placeholder="@Lang('admin::image.form.folder')" class="form-control">';
		html += '  <span class="input-group-btn"><button type="button" title="@Lang('admin::image.button.folder')"  id="button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>';
		html += '</div>';
		
		return html;	
	}
});

$('#button-folder').on('shown.bs.popover', function() {
	$('#button-create').on('click', function() {
		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
			url: '{{ route('admin.image.folder') }}',
			type: 'post',		
			dataType: 'json',
			data: 'folder=' + $('input[name=\'folder\']').val(),
			beforeSend: function() {
				$('#button-create').prop('disabled', true);
			},
			complete: function() {
				$('#button-create').prop('disabled', false);
			},
			success: function(json) {
				// console.log(json);
				if (json['error']) {
					alert(json['error']);
				}
				if (json['success']) {
					alert(json['success']);
										
					$('#button-refresh').trigger('click');
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