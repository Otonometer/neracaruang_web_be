<table class="table mg-b-0" id="pages-table">
    <thead>
        <tr>
            <th>Title</th>
        <th>Image</th>
        <th>Created By</th>
        <th>Updated By</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pages as $page)
        <tr>
            <td>{!! $page->title !!}</td>
            <td>{!! $page->image !!}</td>
            <td>{!! $page->created_by !!}</td>
            <td>{!! $page->updated_by !!}</td>
            <td width="100">
                {!! Form::open(['route' => ['pages.destroy', $page->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('pages.show', [$page->id]) !!}" class='btn btn-outline-secondary btn-xs btn-icon'><i class="fa fa-eye"></i></a>
                    <a href="{!! route('pages.edit', [$page->id]) !!}" class='btn btn-outline-primary btn-xs btn-icon'><i class="fa fa-edit"></i></a>
                    {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs btn-icon', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
