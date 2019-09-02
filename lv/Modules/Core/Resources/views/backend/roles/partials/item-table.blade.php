<form action="{{URL::route("core.backend.roles.update")}}" method="post" class="form-item-update">
<table class="pk-form table " id="item-edit-form">
    <tbody>
    <tr>
        <td class="info-label">Name:</td>
        <td>
            <span>{{$data->item->name}}
                @if($data->item->deleted_at)
                    <span class="tag tag-danger">Deleted</span>
                    @endif

            </span>
            <div class="form-group">
                <input type="text" class="form-control empty" name="name" value="{{$data->item->name}}">
            </div>
        </td>
    </tr>
    <tr>
        <td class="info-label">Slug:</td>
        <td>
            <span>{{$data->item->slug}}</span>
            <div class="form-group">
                <input type="text" class="form-control empty" name="slug" value="{{$data->item->slug}}">
            </div>
        </td>
    </tr>
    <tr>
        <td class="info-label">Details:</td>
        <td>
            <span>{{$data->item->details}}</span>
            <div class="form-group">
                <textarea class="form-control empty" name="details">{{$data->item->details}}</textarea>
            </div>
        </td>
    </tr>
    <tr>
        <td class="info-label">Enabled:</td>
        <td>
            <span>
            @if($data->item->enable == 1)
                <span class="tag tag-success">Yes</span>
            @else
                <span class="tag tag-danger">No</span>
                @endif
                </span>
            <div class="form-group">

                @if($data->item->enable == 1)
                <div class="radio-custom radio-success radio-inline">
                    <input type="radio" name="enable" value="1" checked >
                    <label>Yes</label>
                </div>
                <div class="radio-custom radio-danger radio-inline">
                    <input type="radio" name="enable" value="0">
                    <label>No</label>
                </div>
                @else
                    <div class="radio-custom radio-success radio-inline">
                        <input type="radio" name="enable" value="1" >
                        <label>Yes</label>
                    </div>
                    <div class="radio-custom radio-danger radio-inline">
                        <input type="radio" name="enable" value="0" checked>
                        <label>No</label>
                @endif


            </div>
        </td>
    </tr>
    @if($data->item->createdBy()->exists())
    <tr class="on-edit-hide">
        <td class="info-label">Created By:</td>
        <td>
            <span>
                {{$data->item->createdBy->name}}
                <small>
                / {{$data->item->created_at->diffForHumans()}}
                / {{$data->item->created_at}}
                </small>
            </span>
        </td>
    </tr>
    @endif
    @if($data->item->updatedBy()->exists())
        <tr class="on-edit-hide">
            <td class="info-label">Updated By:</td>
            <td>
            <span>
                {{$data->item->updatedBy->name}}
                <small>
                / {{$data->item->updated_at->diffForHumans()}}
                / {{$data->item->updated_at}}</small>
            </span>
            </td>
        </tr>
    @endif

    @if($data->item->deletedBy()->exists())
        <tr class="on-edit-hide">
            <td class="info-label">Deleted By:</td>
            <td>
            <span>
                {{$data->item->deletedBy->name}}
                <small>/ {{$data->item->deleted_at->diffForHumans()}}
                / {{$data->item->deleted_at}}</small>
            </span>
            </td>
        </tr>
    @endif


    </tbody>
    <tfoot>
    <tr >
        <td colspan="2" >
            <div class="pull-right actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button"
                        class="btn btn-default pk-form-cancel"
                        data-target="#item-edit-form"
                >Cancel</button>
            </div>
        </td>
    </tr>
    </tfoot>
</table>
    <input type="hidden" name="id" value="{{$data->item->id}}">
</form>
