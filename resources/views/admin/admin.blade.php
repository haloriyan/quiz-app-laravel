@extends('layouts.dashboard')

@section('title', 'Admin Accounts')

@section('content')
<hr size="2" color="#2c9cdb" />
<div id="action">
    <button id="action" onclick="munculPopup('#addAdmin')"><i class="fas fa-plus"></i> &nbsp; New Admin</button>
</div>

@if ($message != "")
    <div class="bg-hijau-transparan rounded mb-2 p-2">
        {{ $message }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th class="lebar-15">Role</th>
            <th class="lebar-20"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($admins as $admin)
            @php $role = $admin->role == 1 ? "Super Admin" : "Admin"; @endphp
            <tr>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->username }}</td>
                <td>{{ $role }}</td>
                <td>
                    <button class="hijau" onclick="edit(`{{ $admin }}`)"><i class="fas fa-edit"></i></button>
                    <button class="merah"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="bg"></div>
<div class="popupWrapper" id="addAdmin">
    <div class="popup">
        <div class="wrap">
            <h3>Add New Admin
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#addAdmin')"></i>
            </h3>
            <form action="{{ route('admin.store') }}" method="POST" class="mt-4">
                {{ csrf_field() }}
                <div>Name :</div>
                <input type="text" class="box" name="name">
                <div class="mt-2">Username :</div>
                <input type="text" class="box" name="username">
                <div class="mt-2">Password :</div>
                <input type="password" name="password" class="box">
                <div class="mt-2">Role :</div>
                <select name="role" class="box">
                    <option value="0">Admin</option>
                    <option value="1">Super Admin</option>
                </select>

                <button class="mt-3 active lebar-100">Create</button>
            </form>
        </div>
    </div>
</div>

<div class="popupWrapper" id="editAdmin">
    <div class="popup">
        <div class="wrap">
            <h3>Edit Admin Data
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#editAdmin')"></i>
            </h3>
            <form action="{{ route('admin.update') }}" method="POST" class="mt-4">
                {{ csrf_field() }}
                <input type="hidden" name="admin_id" id="admin_id">
                <div class="mt-2">Name :</div>
                <input type="text" class="box" name="name" id="name">
                <div class="mt-2">Username :</div>
                <input type="text" class="box" name="username" id="username">
                <div class="mt-2">Role :</div>
                <select name="role" id="role" class="box">
                    <option value="0">Admin</option>
                    <option value="1">Super Admin</option>
                </select>

                <button class="mt-3 active lebar-100">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    const edit = data => {
        munculPopup("#editAdmin")
        data = JSON.parse(data)
        select("#editAdmin #admin_id").value = data.id
        select("#editAdmin #name").value = data.name
        select("#editAdmin #username").value = data.username
        select("#editAdmin #role").value = data.role
    }
</script>
@endsection