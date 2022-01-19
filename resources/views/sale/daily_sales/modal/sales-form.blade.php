<div class="modal fade" id="salesFormModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            <form id="add-sales-form" method="POST" action="{{ route('sales.store') }}">
                @csrf
                <div class="row">
                    <label>Date: </label>
                    <input type="text" name="date" class="form-control" data-provide="datepicker" data-date-format="{{ config('app.date_format_javascript') }}">
                </div>
                <div class="row">
                    <label>Customer: </label>
                    <input type="text" name="customer" class="form-control" >
                </div>
                <div class="row">
                    <label>Clerk: </label>
                    <input type="text" name="clerk" class="form-control" >
                </div>
                <div class="row">
                    <label>Amount: </label>
                    <input type="text" name="amount" class="form-control" >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
