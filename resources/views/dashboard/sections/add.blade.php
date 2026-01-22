<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('dashboard/sections.add_sections') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('sections.store') }}" method="post" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <label for="exampleInputPassword1">{{ trans('dashboard/sections.section_name') }}</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="modal-body">
                    <label for="exampleInputPassword1">{{ trans('dashboard/sections.description') }}</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $data->description ?? '') }}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('dashboard/sections.Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('dashboard/sections.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
