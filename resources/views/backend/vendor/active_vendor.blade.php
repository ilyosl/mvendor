@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">All Active Vendors</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Vendors</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">Vendor List</h6>
        <hr/>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Shop Name</th>
                            <th>Vendor User Name</th>
                            <th>Vendor phone</th>
                            <th>Vendor Email</th>
                            <th>Status</th>

                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activeVendor as $key => $vendor)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ $vendor->name }}</td>
                                <td>{{$vendor->username}}</td>
                                <td>{{$vendor->phone}}</td>
                                <td>{{$vendor->email}}</td>
                                <td><span class="btn btn-success">{{$vendor->status}}</span></td>
                                <td>
                                    <a href="{{ route('vendor.details', $vendor->id) }}" class="btn btn-info">Vendor Details</a>
                                    <a href="{{ route('delete.subcategory', $vendor->id) }}" id="delete" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Shop Name</th>
                            <th>Vendor User Name</th>
                            <th>Vendor phone</th>
                            <th>Vendor Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
