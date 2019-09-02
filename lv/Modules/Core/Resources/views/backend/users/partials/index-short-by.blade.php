<div class="btn-group " role="group">
    <button type="button" class="btn btn-outline btn-default"
            data-target="#ModalFormCreate" data-toggle="modal">
        <i class="icon wb-plus" aria-hidden="true"></i>
    </button>
</div>


<div class="pull-xs-left">
    <div class="dropdown">
        <button type="button" class="btn btn-pure" data-toggle="dropdown"
                aria-expanded="false"> Actions
            <span class="icon wb-chevron-down-mini" aria-hidden="true"></span>
        </button>
        <div class="dropdown-menu" role="menu">
            <a class="dropdown-item bulkAction"
               data-action="enable"
               href="javascript:void(0)">Enable</a>
            <a class="dropdown-item bulkAction"
               data-action="disable"
               href="javascript:void(0)">Disable</a>
            <a class="dropdown-item bulkAction"
               data-action="delete"
               href="javascript:void(0)">Delete</a>
            <a class="dropdown-item bulkAction"
               data-action="restore"
               href="javascript:void(0)">Restore</a>
            <a class="dropdown-item bulkAction"
               data-action="permanent-delete"
               href="javascript:void(0)">Permanent Delete</a>
        </div>
    </div>
</div>

<div class="dropdown page-user-sortlist">
    Short By: <a class="dropdown-toggle inline-block shortBySelected"
                 data-short-by="All"
                 data-toggle="dropdown" href="#"
                 aria-expanded="false">All</a>
    <div class="dropdown-menu animation-scale-up animation-top-right
                animation-duration-250 shortBy" role="menu">
        <a class=" dropdown-item" href="javascript:void(0)">All</a>
        <a class="dropdown-item" href="javascript:void(0)">Enabled</a>
        <a class="dropdown-item" href="javascript:void(0)">Disabled</a>
        <a class="dropdown-item" href="javascript:void(0)">Trashed</a>
        <a class="dropdown-item" href="javascript:void(0)">Created Date</a>
        <a class="dropdown-item" href="javascript:void(0)">Recently Logged</a>
        <a class="dropdown-item" href="javascript:void(0)">Never Logged</a>
    </div>
</div>
