$(document).ready(function(){

    percentageEdit();
    searchProject();
    $("#range-input").change(function(){
        var range = $(this).val();
        $('#range-percentage-label').text(range+'%');
    });

    $("#percentage-input-edit").change(function(){
        percentageEdit();
    });

    $("#searchProjectForm").change(function(){
        var searchValue = $(this).val();
        searchProject(searchValue);
    });
    
});

function percentageEdit()
{
    var range = $("#percentage-input-edit").val();
    $('#range-percentage-label-edit').text(range+'%');
}

function storeProject()
{
    event.preventDefault();
    var name = $('#name-input').val();
    var location = $('#location-input').val();
    var date_start = $('#date-start-input').val();
    var date_end = $('#date-end-input').val();
    var budget = $('#budget-input').val();
    var status = $('#status-input').val();
    var percentage = $('#range-input').val();
    var photo = $('#photo-input').val();
    var description = $('#description-input').val();

    $.ajax({
        url: '/project/store',
        method: 'get',
        data: {
            name:name, 
            location:location, 
            description:description,
            date_start:date_start,
            date_end:date_end,
            budget:budget,
            status:status,
            percentage:percentage,
            photo:photo,
        },
        dataType: 'json',
        success: function(data){
            $('#addProject').modal('hide');
        }
    });
}

function searchProject(searchValue ='')
{
    $.ajax({
        url: '/project/searchProject',
        method: 'get',
        data: {
            value:searchValue, 
        },
        dataType: 'json',
        success: function(data){
            $('#projectList').empty();
            $('#projectTotal').text(data.length+' Total');

            $.each(data, function(x) {
                var project_id = data[x].id;
                var url = "project/"+data[x].id;
                var photo = data[x].photo;
                if(photo == null)
                {
                    photo = 'defaultproject.jpg';
                }

                $('#projectList').append(
                    '<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">'+
                        '<div class="card card-custom gutter-b card-stretch">'+
                            '<div class="card-body text-center pt-4">'+
                                '<div class="d-flex justify-content-end">'+
                                    '<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">'+
                                        '<a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                                            '<i class="ki ki-bold-more-hor"></i>'+
                                        '</a>'+
                                        '<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">'+
                                            '<ul class="navi navi-hover">'+
                                                '<li class="navi-header font-weight-bold py-4">'+
                                                    '<span class="font-size-lg">??</span>'+
                                                    '<i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>'+
                                                '</li>'+
                                            '</ul>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="mt-7">'+
                                    '<div class="symbol symbol-circle symbol-lg-90">'+
                                        '<img src="/assets/img/project/'+photo+'" alt="image">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="my-4">'+
                                    '<a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4">'+data[x].name+'</a>'+
                                '</div>'+
                                '<span class="btn btn-text btn-light-warning btn-sm font-weight-bold">'+data[x].status+'</span>'+
                                '<div class="mt-9">'+
                                    '<a href="'+url+'" class="btn btn-light-primary font-weight-bolder btn-sm py-3 px-6 text-uppercase">view project</a>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'
                );
            });
        }
    });
}