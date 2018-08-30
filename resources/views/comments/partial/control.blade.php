<!-- resources/views/comments/partial/controll.blade.php -->

<div class="dropdown float-right hidden-xs hidden-sm">
    <span class="dropdown-toggle btn btn-info btn-xs none-after" type="button" data-toggle="dropdown" style="padding-right: 0.2rem">{!! icon('dropdown') !!}</span>
    <ul class="dropdown-menu dropdown-menu-right" role="menu">
        <li role="presentation">
            <a role="menuitem" tabindex="-1" alt="Edit" title="Edit" class="btn btn-block text-left btn__edit">
                {!! icon('edit') !!} Edit
            </a>
        </li>
        <li role="presentation">
            <a role="menuitem" tabindex="-1" alt="Delete" title="Delete" class="btn btn-block text-left btn__delete">
                {!! icon('delete') !!} Delete
            </a>
        </li>
    </ul>
</div>