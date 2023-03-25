@extends('backend.layouts.app')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title py-1">รายละเอียด</h3>
						<div class="card-tools">
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Export
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="{{ route('backend.{{ model }}.export') }}"><i class="far fa-file-excel"></i> Excel</a>
								</div>
							</div>
							<a class="btn btn-sm btn-success" href="{{ route('backend.{{ model }}.create') }}"><i class="fas fa-plus"></i> Add {{ model }}</a>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<form action="" method="POST" data-text-confirm="ต้องการลบข้อมูล?">
							@method('DELETE')
							@csrf
							<div class="form-row mb-4">
								<div class="col-12 col-md-4">
									Role:  
									<select class="w-75 filter-form select2" id="filter_role">
									  	<option value="">ทั้งหมด</option>
									  	@foreach(\App\Model\Backend\Role::has{{ model }}()->get() as $role)
									  		<option value="{{ $role->name }}">{{ $role->name }}</option>
									  	@endforeach
									</select>
								</div>
								<div class="col-12 col-md-4">
									สถานะ: 
									<select class="form-control d-inline-block w-75 filter-form" id="filter_status">
									  	<option value="">ทั้งหมด</option>
									  	@foreach(\App\Model\{{ model }}::statusOptions() as $value => $text)
									  		<option value="{{ $value }}">{{ $text }}</option>
									  	@endforeach
									</select>
								</div>
							</div>
							<table class="table table-bordered table-striped table-hover table-f-small w-100" id="{{ model }}_datatable">
								<thead class="thead-light">
									<tr>
										<th scope="col" class="text-center">ID</th>
										<th scope="col" class="text-center">Name</th>
										<th scope="col" class="text-center">Email</th>
										<th scope="col" class="text-center">Role</th>
										<th scope="col" class="text-center">Image</th>
										<th scope="col" class="text-center">Created At</th>
										<th scope="col" class="text-center">สถานะ</th>
										<th scope="col" class="text-center">เครื่องมือ</th>
									</tr>
								</thead>
							</table>
						</form>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
		</div>
	</div>
</section>
@endsection

@include('backend.scripts.datatable')
@include('backend.scripts.select2')

@push('after-scripts')
	<script>

	    var filterStatus = '#filter_status';
	    var filterRole = '#filter_role';

	    var dtID = '#{{ model }}_datatable';
	    var dtTable = $(dtID).DataTable({
	        processing: true,
	        serverSide: true,
	        responsive: true,
	        ajax: {
	            url: "{{ route('backend.{{ model }}.list-data') }}",
	            data: function(d) {
	                d.status = $(filterStatus).val();
	                d.role = $(filterRole).val();
	            }
	        },
	        columns: [
	            { data: 'id', className: 'text-center' },
	            { data: 'name' },
	            { data: 'email', className: 'text-center' },
	            { 
	            	data: 'role_names', 
	            	className: 'text-center',
	            	orderable: false,
	            	searchable: false  
	            },
	            { 
	            	data: 'avatar_thumb',
	            	className: 'text-center',
	            	orderable: false,
	            	searchable: false 
	            },
	            { data: 'display_created_at_full_thai', className: 'text-center' },
	            { data: 'display_status', className: 'text-center' },
	            { data: 'id', width: '140', className: 'text-center', orderable: false, searchable: false },
	            { data: 'edit_link', 'visible': false, searchable: false },
	            { data: 'destroy_link', 'visible': false, searchable: false },
	        ],
	        "order": [
	            [ 0, "desc" ]
	        ],
	        'columnDefs': [
		        {
		            'targets': 6,
		            'render': function ( data, type, row ) {
		                return dtTextStatus(data);
		            }
		        },
		        {
		            'targets': 7,
		            'render': function ( data, type, row ) {
		                var btnEdit = dtBtnEdit(row.edit_link);
		                var btnDelete = dtBtnDelete(row.destroy_link);
		                return btnEdit + ' ' + btnDelete;
		            }
		        }
	        ]
	    });

	    $('.filter-form').on("change", function(){ dtTable.draw(); });

	</script>
@endpush