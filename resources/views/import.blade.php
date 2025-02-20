
@if(auth()->user()->role_id == '1')
<form action="{{ route('excel.import') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="excel" id="excel" class="form-control">
    <button class="btn btn-sm btn-primary mt-3">Submit</button>
</form>
@endif
