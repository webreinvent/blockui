
@if(count($data['list']))


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
            <th>Enable</th>
            <th class="hidden-sm-down">Slug</th>
            <th class="hidden-sm-down">Users</th>
            <th class="hidden-sm-down">Roles</th>
            <th class="hidden-sm-down">Actions</th>
        </tr>
        </thead>

        <tbody>


        @foreach($data['list'] as $item)
            <tr data-id="{{$item->id}}" data-enable="{{$item->enable}}">
                <td>
                <span class="checkbox-custom checkbox-primary">
                            <input class="selectable-item" type="checkbox"
                                   value="{{$item->id}}">
                            <label for="row-{{$item->id}}"></label>
                          </span>
                </td>
                <td class="hidden-sm-down">{{$item->id}}</td>
                <td >{{$item->name}}

                    @if($item->deleted_at)
                        <label class="tag tag-danger">Deleted</label>
                        @endif

                </td>

                <?php
                if($item->enable == 1)
                {
                    $enable = "Yes";
                    $class = "btn-success";
                } else
                {
                    $enable = "No";
                    $class = "btn-danger";
                }
                ?>

                <td><a href="{{\URL::route('core.backend.roles.toggle')}}"
                       class="btn btn-xs enableToggle btn-href {{$class}}">{{$enable}}</a></td>
                <td class="hidden-sm-down">{{$item->slug}}</td>
                <td class="hidden-sm-down">{{$item->users_count}}</td>
                <td class="hidden-sm-down">{{$item->permissions_count}}</td>

                <td>

                    <a href="{{\URL::route('core.backend.roles.read', [$item->id])}}"
                       class="btn btn-sm btn-icon btn-flat btn-default">
                        <i class="icon wb-eye" aria-hidden="true"></i>
                    </a>

                    <a href="{{\URL::route('core.backend.roles.delete', ['id'=>$item->id])}}"
                       class="btn btn-sm btn-icon btn-flat btn-default itemDelete">
                        <i class="icon wb-trash" aria-hidden="true"></i>
                    </a>

                </td>
            </tr>
        @endforeach

        </tbody>


    </table>



@endif
