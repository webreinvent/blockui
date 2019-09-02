
<table class="table"
       data-plugin="selectable" data-row-selectable="true">
    <thead>
    <tr>
        <th class="w-50">
<span class="checkbox-custom checkbox-primary">
<input class="selectable-all" type="checkbox"><label></label>
</span>
        </th>
        <th class="hidden-sm-down">#</th>
        <th>Name</th>
        <th>Email/Mobile</th>
        <th>Enable</th>
        <th class="hidden-sm-down">Roles</th>
        <th class="hidden-sm-down" width="200">Actions</th>
    </tr>
    </thead>
    <tbody >

    @foreach($data['list'] as $item)
        <tr>
            <td >
                <span class="checkbox-custom checkbox-primary">
                            <input class="selectable-item" type="checkbox"
                                   value="{{$item->id}}">
                            <label for="row-{{$item->id}}"></label>
                          </span></td>
            <td class="hidden-sm-down">{{$item->id}}</td>
            <td>{{$item->name}}
                @if($item->deleted_at)
                    <span class="tag tag-danger">Deleted</span>
                @endif

                @if($item->last_login)
                    <br/>
                <small >Last Login: {{$item->last_login}} / <span class="tag tag-success">{{ \Carbon::parse($item->last_login)->diffForHumans() }}</span></small>
                    @endif

            </td>
            <td>{{$item->email}}
            <br/> {{$item->mobile}}
            </td>
            <td>
                @if($item->enable == 0)
                    <a href="{{route('core.backend.users.enable', [$item->id])}}"
                       class="btn btn-xs btn-href btn-danger enableToggle ">No</a>
                @else
                    <a href="{{route('core.backend.users.disable', [$item->id])}}"
                    class="btn btn-xs btn-href btn-success enableToggle ">Yes</a>
                @endif
            </td>
            <td class="hidden-sm-down">
                @if($item->roles)
                    @foreach($item->roles as $role)
                        <a href="{{route('core.backend.roles.read', [$role->id])}}"
                           target="_blank">{{$role->name}}</a>,
                    @endforeach
                @endif
            </td>
            <td class="hidden-sm-down">

                <a href="{{route('core.frontend.loginByUrl', [Crypt::encrypt($item->id)])}}"
                   target="_blank"
                   class="btn btn-sm btn-icon btn-flat btn-default">
                    <i class="icon fa-external-link" aria-hidden="true"></i>
                </a>

                <?php

                    $email = $item->email;
                    $name = explode(" ", $item->name);

                    $first_name = $name;
                    if(isset($name[0]))
                    {
                        $first_name = $name[0];
                    }


                    if(isset($name[1]))
                    {
                    $last_name = $name[1];
                    } else
                    {
                      $last_name = null;
                    }


                ?>


                <a href="http://webreinvent.us14.list-manage1.com/subscribe?u=a40a8baaefeabf053558681d6&id=8d23c30678&MERGE0={{$email}}&MERGE1={{$first_name}}&MERGE2={{$last_name}}"
                   target="_blank"
                   class="btn btn-sm btn-icon btn-flat btn-default">
                    <i class="icon fa-envelope" aria-hidden="true"></i>
                </a>

                <a href="{{route('core.backend.users.view', [$item->id])}}"
                   target="_blank"
                   class="btn btn-sm btn-icon btn-flat btn-default">
                    <i class="icon wb-eye" aria-hidden="true"></i>
                </a>

                <a href="{{route('core.backend.users.edit', [$item->id])}}"
                   target="_blank"
                   class="btn btn-sm btn-icon btn-flat btn-default">
                    <i class="icon wb-pencil" aria-hidden="true"></i>
                </a>

                <a href="{{route('core.backend.users.delete', [$item->id])}}"
                   class="btn btn-sm btn-icon btn-flat btn-default itemDelete">
                    <i class="icon wb-trash" aria-hidden="true"></i>
                </a>

            </td>
        </tr>

    @endforeach



    </tbody>
</table>
