@extends('backend.layouts.app')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title py-1">Form Inputs 
							<small>
								(Link to Example: 
								<a href="https://adminlte.io/themes/v3/pages/forms/general.html" target="_blank">General form</a>, 
								<a href="https://adminlte.io/themes/v3/pages/forms/advanced.html" target="_blank">Advaned form</a>,
								<a href="https://adminlte.io/themes/v3/pages/forms/editors.html" target="_blank">Editors</a>,
								<a href="https://adminlte.io/themes/v3/pages/forms/validation.html" target="_blank">Validation</a>
								)
							</small>
						</h3>
					</div>
					<div class="card-body">

						<div class="form-group row">
							<label for="name" class="col-sm-2 col-form-label text-lg-right">Input <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="name" id="name" placeholder="Input">
							</div>
						</div>

						<div class="form-group row">
							<label for="name" class="col-sm-2 col-form-label text-lg-right">Textarea <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<textarea class="form-control" id="" rows="3"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label for="name" class="col-sm-2 col-form-label text-lg-right">TinyMCE<br>Filemanager</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="tinymce_textarea" rows="20"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label for="dt_picker" class="col-sm-2 col-form-label text-lg-right">DateTime (range) Picker</label>
							<div class="col-sm-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
									</div>
									<input type="text" name="dt_picker" class="form-control" id="dt_picker">
								</div>
								<small class="form-text text-muted">
									<a href="https://www.daterangepicker.com/" target="_blank">Link to document (datarangepicker.com)</a>
								</small>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

{{-- TinyMCE --}}
@include('backend.scripts.tinymce')

{{-- DateRange Picker --}}
@include('backend.scripts.daterangepicker')

@push('after-scripts')
<script>

	/* 
	 *
	 * TinyMCE 
	 * 
	 */
	// editorConfig.selector = '#...';
	tinymce.init(editorConfig);

	/* 
	 *
	 * DateRange Picker 
	 * 
	 */
	$('#dt_picker').daterangepicker({
		startDate: moment(),
		showDropdowns: true,
		timePicker: true,
		timePickerIncrement: 5,
		timePicker24Hour: true,
		singleDatePicker: true,
		locale: {
		  	format: 'YYYY-MM-DD HH:mm'
		}
	});
</script>
@endpush