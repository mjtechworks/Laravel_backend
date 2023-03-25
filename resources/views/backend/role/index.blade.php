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
							@can('add role list')
								<a class="btn btn-sm btn-success" href="{{ route('backend.role.create') }}"><i class="fas fa-plus"></i> Add Role</a>
							@endcan
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<form action="" method="POST" data-text-confirm="ต้องการลบข้อมูล? (** ลบแล้วไม่สามารถกูคืนได้)">
							@method('DELETE')
							@csrf
							<table class="table table-bordered table-striped table-hover table-f-small w-100" id="role_datatable">
								<thead class="thead-light">
									<tr>
										<th scope="col" class="text-center">ID</th>
										<th scope="col" class="text-center">Name</th>
										<th scope="col" class="text-center">Users</th>
										<th scope="col" class="text-center">Permissions</th>
										<th scope="col" class="text-center">Created At</th>
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

@push('after-scripts')
	<script>

	    var filterStatus = '#filter_status';

	    var dtID = '#role_datatable';
	    var dtTable = $(dtID).DataTable({
	    	processing: true,
	    	serverSide: true,
	    	responsive: true,
	    	ajax: {
	    		url: "{{ route('backend.role.list-data') }}",
	    		data: function(d) {
	                // d.status = $(filterStatus).val();
	            }
	        },
	        columns: [
		        { data: 'id', width: '50', className: 'text-center' },
		        { data: 'name', width: '400', className: 'text-center' },
		        { data: 'users_count', width: '50', className: 'text-center' },
		        { data: 'permissions_count', width: '50', className: 'text-center' },
		        { data: 'display_created_at_full_thai', className: 'text-center' },
		        { data: 'id', width: '150', className: 'text-center', orderable: false, searchable: false },
		        { data: 'edit_link', 'visible': false, searchable: false },
		        { data: 'destroy_link', 'visible': false, searchable: false },
	        ],
	        "order": [
	        	[ 0, "desc" ]
	        ],
	        'columnDefs': [
		        {
		        	'targets': 5,
		        	'render': function ( data, type, row ) {
		        		if (row.name == 'super admin') return '';
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