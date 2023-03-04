@extends('v1.layouts.main')
@section('content')
    @if(session('error'))
        <div class="card shadow bg-danger text-white" style="margin-bottom:20px;">
            <div class="card-body" style="overflow-x:auto;padding:10px;">{!! session('error') !!}</div>
        </div>
    @endif
    @if(session('success'))
        <div class="card shadow bg-success text-white" style="margin-bottom:20px;">
            <div class="card-body" style="overflow-x:auto;padding:10px;">{!! session('success') !!}</div>
        </div>
    @endif
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Organizer Management</h1>
        <div class="d-none d-sm-inline-block">
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Organizer List</h6>
                    <div class="btn-group btn-sm nospiner" >
                        <a  href="{{ route('admin.v1.organizer.create') }}"  class="btn btn-success btn-sm" >
                            <i class="fas fa-fw fa-plus"></i> Add Data
                        </a>
                    </div> 
                </div>
                <div class="card-body" style="overflow-x:auto;padding:20px;">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Organizer Name</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                            <tr>
                                <td>{{ ($pagination['current_page'] - 1) * $pagination['per_page'] + $loop->iteration }}</td>
                                <td>{{ $data['organizerName'] }}</td>
                                <td><img src="{{ $data['imageLocation'] }}" width="200"></td>
                                <td align="center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('admin.v1.sport-events.index',['organizerId' => $data['id']]) }}" class="dropdown-item">Sport Events</a>
                                            <a href="{{ route('admin.v1.organizer.edit',$data['id']) }}" class="dropdown-item">Edit</a>
                                            <a href="{{ route('admin.v1.organizer.delete',$data['id']) }}" onclick="return confirm('Confirm Delete')" class="dropdown-item">Delete</a>                                              
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation d-flex">
                        <ul class="pagination justify-content-center">
                            @if(isset($pagination['current_page']))
                                @if((isset($pagination['links']['next'])) && (!isset($pagination['links']['previous'])))
                                    <li class="page-item"><a class="page-link" href="{{ route('admin.v1.organizer.index',['page' => $pagination['current_page'] + 1]) }}">Next</a></li>
                                @elseif((!isset($pagination['links']['next'])) && (isset($pagination['links']['previous'])))
                                    <li class="page-item"><a class="page-link" href="{{ route('admin.v1.organizer.index',['page' => $pagination['current_page'] - 1]) }}">Previous</a></li>
                                @elseif((isset($pagination['links']['next'])) && (isset($pagination['links']['previous'])))
                                    <li class="page-item"><a class="page-link" href="{{ route('admin.v1.organizer.index',['page' => $pagination['current_page'] - 1]) }}">Previous</a></li>
                                    <li class="page-item"><a class="page-link" href="{{ route('admin.v1.organizer.index',['page' => $pagination['current_page'] + 1]) }}">Next</a></li>
                                @endif
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#checkall").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
