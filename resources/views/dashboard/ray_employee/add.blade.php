<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافة موظف جديد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('ray_employee.store') }}" method="post" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <label for="exampleInputPassword1">الاسم</label>
                    <input type="text" name="name" class="form-control"><br>

                    <label>البريد الالكتروني</label>
                    <input type="email" name="email" class="form-control"><br>

                    <label>كلمة المرور</label>
                    <input type="password" name="password" class="form-control"><br>
                    <div class="form-group">
                        <label for="password_confirmation">تأكيد كلمه المرور</label>
                        <input type="password" class="form-control" name="password_confirmation"
                            id="password_confirmation">
                    </div>
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
