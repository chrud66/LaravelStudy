<!-- resources/views/comments/partial/controll.blade.php -->

<div class="dropdown pull-right hidden-xs hidden-sm">
    <span class="dropdown-toggle btn btn-default btn-xs" type="button" data-toggle="dropdown">
        {!! icon('dropdown') !!}
    </span>
    <ul class="dropdown-menu" role="menu">
        <li role="presentation">
            <a role="menuitem" tabindex="-1" alt="Edit" title="Edit" class="btn btn__edit">
                {!! icon('update') !!} Edit
            </a>
        </li>
        <li role="presentation">
            <a role="menuitem" tabindex="-1" alt="Delete" title="Delete" class="btn btn__delete">
                {!! icon('delete') !!} Delete
            </a>
        </li>
    </ul>
</div>