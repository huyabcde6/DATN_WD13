<x-app-web-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Create Users
                            <a href="{{ url('userAdmin') }}" class="btn btn-danger float-end ">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{url('userAdmin')}}" method="POST">
                            @csrf
                                
                            <div class="mb-3">
                                <label for=""> Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for=""> Email</label>
                                <input type="text" name="email" value="{{ old('email') }}" class="form-control" />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for=""> Password</label>
                                <input type="text" name="password" value="{{ old('password') }}" class="form-control" />
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for=""> Roles</label>
                                <select name="roles[]" class="form-control" multiple>
                                    <option value="">Select Roles</option>
                                    @foreach ($roles as $role )
                                    <option @selected(in_array($role, old('roles', []))) value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-web-layout>
