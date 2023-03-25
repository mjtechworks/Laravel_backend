<table>
    <thead>
    <tr>
        <th><b>ID</b></th>
        <th><b>Name</b></th>
        <th><b>Email</b></th>
        <th><b>Profile Image</b></th>
        <th><b>Roles</b></th>
        <th><b>สถานะ</b></th>
        <th><b>วันที่สร้าง</b></th>
    </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->has_avatar)
                        <a href="{{ $user->avatar_thumb }}">{{ $user->avatar_thumb }}</a></td>
                    @endif
                <td>{{ $user->roles->implode('name', ', ') }}</td>
                <td>{{ $user->display_status }}</td>
                <td>{{ $user->display_created_at_full_thai }}</td>
            </tr>
        @endforeach
    </tbody>
</table>