<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
// En la vista
@include('modal')
<a data-toggle="modal" href="{{ route('posts.create') }}" data-target="#myModal">Añadir nuevo post</a>