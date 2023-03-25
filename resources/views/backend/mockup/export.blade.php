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
        @foreach (${{ model }}s as ${{ model }})
            <tr>
                <td>{{ ${{ model }}->id }}</td>
                <td>{{ ${{ model }}->name }}</td>
                <td>{{ ${{ model }}->email }}</td>
                <td>
                    @if (${{ model }}->has_avatar)
                        <a href="{{ ${{ model }}->avatar_thumb }}">{{ ${{ model }}->avatar_thumb }}</a></td>
                    @endif
                <td>{{ ${{ model }}->roles->implode('name', ', ') }}</td>
                <td>{{ ${{ model }}->display_status }}</td>
                <td>{{ ${{ model }}->display_created_at_full_thai }}</td>
            </tr>
        @endforeach
    </tbody>
</table>