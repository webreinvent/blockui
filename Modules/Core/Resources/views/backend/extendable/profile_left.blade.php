<div class="card card-shadow text-xs-center">
    <div class="card-block">
        <a class="avatar avatar-lg" href="javascript:void(0)">
            <img v-bind:src="item.thumbnail" />
        </a>
        <h4 class="profile-user">@{{ item.name }}</h4>
        <p>
            <span v-for="role in item.roles" class="tag tag-round tag-default" style="margin-right: 1px;">@{{ role.name }}</span> &nbsp
        </p>
    </div>
</div>
