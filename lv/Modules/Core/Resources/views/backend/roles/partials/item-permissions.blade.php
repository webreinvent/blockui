<table class="table m-b-0">
    <tbody>
    @if($data->permissions)
        @foreach($data->permissions as $permission)
    <tr>
        <td>{{ucwords($permission->name)}}</td>
        <td>
            @if(in_array($permission->id, $data->item->permission_ids))
                <button data-url="{{route("core.backend.roles.permissions.toggle",
                [$data->item->id, $permission->id])}}"
                   class="btn btn-xs btn-success permissionToggle">Yes</button>
                @else
                <button data-url="{{route("core.backend.roles.permissions.toggle",
                [$data->item->id, $permission->id])}}"
                   class="btn btn-xs btn-danger permissionToggle">No</button>
            @endif
        </td>
    </tr>
    @endforeach
    @endif
    </tbody>
</table>
