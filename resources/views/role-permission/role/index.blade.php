<x-app-web-layout>

    @include('role-permission.nav-links')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>
                            Permissions
                            <a href="{{ url('roles/create') }}" class="btn btn-primary float-end "> Add
                                Roles</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <a href="{{ url('roles/'.$role->id.'/give-permission') }}" class="btn btn-warning mx-2">Add / Edit Role Permission</a>
                                            <a href="{{ url('roles/'.$role->id.'/edit') }}" class="btn btn-success">Edit</a>
                                            <a href="{{ url('roles/'.$role->id.'/delete') }}"class="btn btn-danger mx-2"
                                                onclick="return confirm('Are you sure you want to delete this permission?');">
                                                Delete
                                             </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-web-layout>
