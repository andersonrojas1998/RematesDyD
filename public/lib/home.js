$(document).ready(function() {

    dt_products();


});

/*
var employmentList=function(){

    $.ajax({
        url:"/rt_employmentList",
        type:"GET",
        dataType:"JSON",
        success:function(data) {
            
            for(let i=0;i<6;i++){   
                let logo=(data[i].logo=="")? 'logo_pordefecto.gif':data[i].logo;
                 $('.listEmployed').append('<div class="col-lg-4 grid-margin stretch-card">'+
                '<div class="card"> '+
                '<img class="rounded mx-auto d-block pt-2" src="/assets/enterprise/'+logo+'"  width="100" height="90">' +
                '<h4 class="visible-xs visible-md visible-lg  pt-4 ml-4">'+data[i].oferta+'</h4>'+   
                  '<div class="card-body"> <a href=""> '+  data[i].empresa +  ' - ' +  data[i].ciudad  + ' &nbsp; <i class="mdi mdi-map-marker"></i>'+
                    '<p class="text-muted"><i class="mdi mdi-timer"></i>  Publicado  '+data[i].fecha_publicacion+'</p>'+
                 ' </a>'+
                  '</div>'+
                  '<div class="card-footer text-muted"><div class="row"><div class="col-lg-8" style="color:orange"><b>'+data[i].rango  +' Millones</b> </div><div class="col-lg-4">'+data[i].modalidad+'  <i class="mdi mdi-google-maps"></i></div></div></div>'+
                '</div>'+
              '</div>')
            }                      
        }
    });    
}
*/

function dt_products(){

    $('#table-product').DataTable({
        dom: 'Bfrtip',
        destroy:true,
        buttons: ['excel', 'pdf'],
        ajax:{
            url:  '/products/list',
            method: "GET",
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            dataSrc: function(json){
                if(!json.data){
                    return [];
                } else {
                    return json.data;
                }
            }
        },
        columnDefs: [
            {"className": "text-center", "targets": "_all"},
        ],
        columns:[
            {"data": "id", render(data){ return '<b class="text-primary text-uppercase"> '+ data +'</b>' ;  }},
            {"data": "titulo", render(data){ return '<b class="text-primary text-uppercase"> '+ data +'</b>' ;  }},
            {"data": "descripcion", render(data){ return '<p class="text-uppercase"> '+ data +'</p>' ;  } },            
            {"data": "detalle", render(data){ return '<a href="" class="text-uppercase"> '+ data +'</a>' ;  } },            
            {"data": "imagen", render(data){ return '<img src="'+data+'" width="200" height="100"> </img>' ;  } },            
            {"data": "descuento", render(data){  return '<p class="text-uppercase"> '+ data +'</p>' ; }},
            {"data": "descuento", render(data){  return '<button class="btn btn-danger">Eliminar <i class="glyphicon glyphicon-minus"></i></button>' ; }}
        ],
    });
 }
