@extends('admin.layout.dashboard')
@section('page_name')
   Pending Dealers
@endsection
@section('content')
    
    @if (Session::has('succed'))
        <div class="alert alert-success"><strong>{{ Session::get('succed') }}</strong></div>
    @endif

    @if (Session::has('fail'))
        <div class="alert alert-danger"><strong>{{ Session::get('fail') }}</strong></div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <strong>{{ $error }}</strong><br>
            @endforeach
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">

            <div class="card" id="customerList">
                <div class="card-header ">
					<h4 class="card-title mb-0 flex-grow-1">@yield('page_name') List</h4>
					<div class="text-end buttons">
						<!--<button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add Dealer</button>
						<button class="btn btn-danger delete-multiple"><i class="ri-delete-bin-2-line"></i> Bulk Delete</button>-->
					</div>
                </div>

                <div class="card-body">
                    <div>
                        <div class="table-responsive mb-1">
                            <table class="table align-middle" id="roleTable">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <!--<th style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input sub_chk" type="checkbox" id="checkAll">
                                            </div>
                                        </th>-->
                                        <th>Name</th>
										<th>Email</th>
                                        <th>Mobile</th>
                                        <th>Registration Type</th>
                                        <th>NRIC/Company Registration No.</th>
                                        <th>Occupation</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @php $i = 1; @endphp
                                    @foreach ($dealers as $dealer)
                                        <tr>
                                            <?php
                                                $dealer_data = json_decode($dealer->data);
                                            ?>
                                            <td>{{$dealer_data->company_name ?? $dealer_data->first_name." ".$dealer_data->last_name}}</td>
                                            <td>{{$dealer->email}}</td>
                                            <td>{{$dealer_data->mobile_number}}</td>
                                            <td>{{ucfirst($dealer_data->registration_type)}}</td>
                                            <td>{{$dealer_data->identity_number}}</td>
                                            <td>{{$dealer_data->occupation}}</td>
                                            <td>{{$dealer_data->address}}</td>
                                            <td><span class="badge rounded-pill text-bg-primary">{{ucfirst($dealer->status)}}</span></td>
                                            <td>{{ucfirst($dealer->created_at)}}</td>
                                            <td>
                                            <div class="dropdown">
													<a href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false" class="">
														<i class="ri-more-2-fill"></i>
													</a>
													<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1" style="">
														<li>
															<button class="dropdown-item approve-btn" data-id="{{ $dealer->user_id }}">Approve</button>
														</li>
														<li> 
															<button class="dropdown-item reject-btn" data-bs-toggle="modal" data-bs-target="#reject-dealer-form" data-id="{{ $dealer->user_id }}">Reject</button>
														</li>
													</ul>
												</div> 
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </form>
                            <!--end of form for multiple delete-->
                        </div>

                    </div>
                    
					<!--Add Dealer Form Starts-->
                    <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Dealer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                <form action="{{ route('dealer.add_user') }}" method="post" class="add-user-form">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="mb-3 col-sm-6">
                                                    <label for="brand-field" class="form-label">First Name</label>
                                                    <input type="text" id="" name="first_name" class="form-control" placeholder="Enter First Name" required />
                                                </div>

                                                <div class="mb-3 col-sm-6">
                                                    <label for="brand-field" class="form-label">Last Name</label>
                                                    <input type="text" id="" name="last_name" class="form-control" placeholder="Enter Last Name" />
                                                </div>
                                                <div class="mb-3 col-sm-12">
                                                    <label for="brand-field" class="form-label">Email</label>
                                                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter email" required />
                                                </div>
                                                <div class="mb-3 col-sm-6">
                                                    <label for="password-field" class="form-label">Password</label>
                                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" />
                                                </div>

                                                <div class="mb-3  col-sm-6">
                                                    <label for="password-field" class="form-label">Confirm password</label>
                                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Enter confirm password" />
                                                </div>
                                                <div class="mb-3  col-sm-12">
                                                    <label for="status-field" class="form-label">Status</label>
                                                    <select class="form-control" name="status" data-trigger name="status-field" id="status-field">
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3  col-sm-12">
                                                    <label for="status-field" class="form-label">Roles</label>
                                                    <div class="row">
														<div class="col-lg-12" id="user-roles">
                                                            <div class="form-check form-check-inline">
                                                                <input type="checkbox" value="Admin" class="form-check-input" id="role-admin" name="roles[]">
                                                                <label for="role-admin">Admin</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input type="checkbox" value="Dealer" class="form-check-input" checked name="roles[]" id="role-dealer">
                                                                <label for="role-dealer">Dealer</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input type="checkbox" value="Customer" class="form-check-input" name="roles[]" id="role-customer">
                                                                <label for="role-customer">Customer</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input type="checkbox" value="SalesPerson" class="form-check-input" name="roles[]" id="role-sales-person">
                                                                <label for="role-sales-person">Sales Person</label>
                                                            </div>
                                                        </div>		
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Add Dealer</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end of add modal -->


                    <!--start of edit modal -->

                    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Dealer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form action="{{ url('/admin/dealer/update-user/') }}" enctype="multipart/form-data" method="post" class="edit-user-form">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="id" id="id">
                                        <div class="row">
                                            <div class="mb-3 col-sm-6">
                                                <label for="brand-field" class="form-label">First Name</label>
                                                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter First Name" required />
                                            </div>
                                            <div class="mb-3 col-sm-6">
                                                <label for="brand-field" class="form-label">Last Name</label>
                                                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter Last Name" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="brand-field" class="form-label">Email</label>
                                            <input type="text" id="email" readonly name="email" class="form-control" value="" placeholder="Enter email" required />
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <label for="" class="form-label">Status</label>
                                                <select class="form-control" name="status" data-trigger id="statuss">
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label for="" class="form-label">Roles</label>
                                                <div class="row">
                                                    <div class="col-lg-12" id="edit-user-roles">
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input edit-user-roles" value="Admin" name="roles[]" id="edit-role-admin" >
                                                            <label for="edit-role-admin">Admin</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input edit-user-roles" value="Dealer" name="roles[]" id="edit-role-dealer">
                                                            <label for="edit-role-dealer">Dealer</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input edit-user-roles" value="Customer" name="roles[]" id="edit-role-customer">
                                                            <label for="edit-role-customer">Customer</label>
                                                        </div>
														<div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input edit-user-roles" value="SalesPerson" name="roles[]" id="edit-role-sales-person">
                                                            <label for="edit-role-sales-person">Sales Person</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger" id="add-btn">Update</button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Edit Modal -->


                    <!--start of edit modal -->

                    <div class="modal fade" id="reject-dealer-form" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Reject Dealer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form action="{{ route('admin.dealer.reject') }}" method="post" class="update-reject-form">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="id" id="uid" value="" />
                                        <div class="row">
                                            <div class="mb-1 col-sm-12">
                                                <label for="username-field" class="form-label">Reason</label>
                                                <textarea id="notes" name="notes" class="form-control" placeholder="Please enter reason for rejection."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger" id="add-btn">Reject</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Edit Modal -->



                    <!--end modal -->
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->

    </div>
    <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection

@section('modalAjax')
    <script>
        $(document).ready(function() {
			jQuery(".add-user-form").validate({
				rules: {
					first_name: "required",
					email: "required",
					password: {
						required: true,
						minlength: 6
					},
					password_confirmation: {
						required: true,
						minlength: 6,
						equalTo: "#password"
					},
					"roles[]": { 
						required: true,
						minlength: 1
					},
				},
				messages: {
					first_name: "Please enter first name.",
					email: "Please enter email address.",
					password: {
						required: "Please enter password.",
						minlength:"Password length must be greater than 6 characters.",
					},
					password_confirmation: {
						required: "Please enter confirm password.",
						minlength:"Password length must be greater than 6 characters.",
						equalTo: "Confirm password should be same as password."
					},
					"roles[]": {
						required: "Please select atleast one user role.",
					}
				},
				errorPlacement: function(error, element) {
					if(element.is(":checkbox") ) {
						error.insertAfter("#user-roles");
					} else { 
						error.insertAfter( element );
					}					
				},
				submitHandler: function(form) {
					return true;
				}
			});	
            $(document).on('click', '.editbrand', function() {
                var catid = $(this).val();
                //alert(catid);
                $('#editModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "/admin/dealer/edit-user/" + catid,
                    success: function(response) {
                        $(".edit-user-form #email").val(response.user.email);
                        $(".edit-user-form #first_name").val(response.user.first_name);
                        $(".edit-user-form #last_name").val(response.user.last_name);
                        $(".edit-user-form #id").val(response.user.id);
                        var user_roles = response.roles;
						var roles = JSON.parse("[" + user_roles + "]");
						$('.edit-user-form .edit-user-roles').each(function() {
							var sThisVal = $(this).val();
							var idx = $.inArray(sThisVal, roles[0]);
							if(idx != -1) {
								$(this).prop("checked", true);
							} else {
							  $(this).prop("checked", false);
							}
						});
						$('.edit-user-form #statuss').val(response.user.status).change();
                    }
                });
            });
			//Edit User Form Validation
			jQuery(".edit-user-form").validate({
				rules: {
					first_name: "required",
					email: "required",
					"roles[]": { 
						required: true,
						minlength: 1
					},
				},
				messages: {
					first_name: "Please enter first name.",
					email: "Please enter email address.",
					"roles[]": {
						required: "Please select atleast one user role.",
					}
				},
				errorPlacement: function(error, element) {
					if(element.is(":checkbox") ) {
						error.insertAfter("#edit-user-roles");
					} else { 
						error.insertAfter( element );
					}					
				},
				submitHandler: function(form) {
					return true;
				}
			});
            //Approve Dealer
            jQuery('.approve-btn').click(function(){
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to approve this dealer?",
                    icon: "question",
                    showCancelButton: true,
                    showCloseButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/admin/dealer/approve-dealer/" + id;
                    }
                });
            });
            //Reject Dealer
            $(document).on('click', '.reject-btn', function() {
                var id = $(this).attr('data-id');
                $(".update-reject-form #uid").val(id);
                $('#reject-dealer-form').modal('show');
            });
            //Validate Rejection Form
            jQuery(".update-reject-form").validate({
				rules: {
					notes: "required",
				},
				messages: {
					notes: "Please enter reason for rejection.",
				},
				submitHandler: function(form) {
					return true;
				}
			});
        });     
    </script>        
    <script>
        $(document).ready(function() {


            var table = $('#roleTable').DataTable({
                'columnDefs': [{
                    'targets': [9],
                    /* column index */
                    'orderable': false,
                    /* true or false */
                }],
                'select': {
                    'style': 'multi',
                    'selector': 'td:first-child'
                },
				lengthChange: true,
                searching: true,
				"drawCallback": function () {
					$('.dataTables_paginate > ul').addClass('pagination-separated justify-content-center justify-content-sm-end mb-sm-0');
				},
				buttons: [
					{ 
						extend: 'excel', 
						text: 'Download List', 
						title: 'List of Dealers',
						exportOptions: {
							columns: ':not(:last-child)',
						} 				
					}
				]
            });
			table.buttons().container().appendTo('.buttons');
            $("#checkAll").on("click", function(e) {
                var rows = table.rows({
                    'search': 'applied'
                }).nodes();
                // Check/uncheck checkboxes for all rows in the table
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });
            $('#roleTable tbody').on('change', 'input[type="checkbox"]', function() {
                // If checkbox is not checked
                if (!this.checked) {
                    var el = $('#checkAll').get(0);
                    // If "Select all" control is checked and has 'indeterminate' property
                    if (el && el.checked && ('indeterminate' in el)) {
                        // Set visual state of "Select all" control
                        // as 'indeterminate'
                        el.indeterminate = true;
                    }
                }
            });
            //Single Delete on Remove button click
            $('.remove-brand-btn').on('click', function(e) {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to delete this dealer?",
                    icon: "question",
                    showCancelButton: true,
                    showCloseButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/admin/dealer/delete-user/" + id;
                    }
                });
            });
            // bUlk Delete
            $('.delete-multiple').on('click', function(e) {
                var users = [];
                $('#roleTable tbody input[type="checkbox"]:checked').each(function() {
                    users.push($(this).val())
                });
                if (users.length > 0) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Are you sure you want to delete selected dealer?",
                        icon: "question",
                        showCancelButton: true,
                        showCloseButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //alert("Deleted");
                            window.location.href = "/admin/dealer/delete-bulk-user/" + users;
                        }
                    });
                } else {
                    Swal.fire({
                        title: "No dealer selected.",
                        text: "",
                        icon: "warning",
                        showCancelButton: true,
                        showCloseButton: true,
                    });
                }
            });
        });
    </script>
@endsection
