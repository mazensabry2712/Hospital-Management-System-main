<!-- Modal -->
<div class="modal fade" id="update_password{{ $laboratorie_employee->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ trans('dashboard/doctors.change_password') }} {{ $laboratorie_employee->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('update_password_laboratorie_employee') }}" method="post" autocomplete="off">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password">{{ trans('dashboard/doctors.new_password') }}</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="form-group">
                        <label
                            for="password_confirmation">{{ trans('dashboard/doctors.password_confirmation') }}</label>
                        <input type="password" class="form-control" name="password_confirmation"
                            id="password_confirmation">
                    </div>

                    <input type="hidden" name="id" value="{{ $laboratorie_employee->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('dashboard/doctors.Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('dashboard/doctors.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
