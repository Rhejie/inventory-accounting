<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var datatable = $('#kt_datatable').KTDatatable({
    data: {
        type: 'remote',
        source: '_load_sales',
        pageSize: 10
    },
    layout: {
        class: 'datatable-bordered',
        scroll: false,
        footer: false
    },
    sortable: true,
    pagination: true,
    mobile: {
        layout:'compact'
    },
    search: {
        input: $('#kt_datatable_search_query'),
        key: 'generalSearch'
    },
    theme: 'default',
    columns: [
        {
            field: 'date',
            title: 'Date'
        },
        {
            field: 'customer',
            title: 'Customer'
        },
        {
            field: 'vat',
            title: 'Vat'
        },
        {
            field: 'discount',
            title: 'Discount'
        },
        {
            field: 'amount',
            title: 'Amount'
        }

    ]
});
</script>
