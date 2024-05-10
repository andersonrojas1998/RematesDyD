

$(function(){

   

    $(document).on('click', '#save-brand', function(){
        let funTransitions = function(){
            if(!$('#save-brand').attr('disabled')){
                $('#save-brand').attr('disabled', true);
                $('#form-fields-brand').addClass('d-none');
                $('#spinner-brand').removeClass('d-none');
            }else{
                $('#save-brand').attr('disabled', false);
                $('#form-fields-brand').removeClass('d-none');
                $('#spinner-brand').addClass('d-none');
            }
        }
        funTransitions();
        let formData = new FormData($('#create-brand-form')[0]);
        $.ajax({
            url: $('#create-brand-form').attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            error: function(jqXHR, textStatus, errorThrown){
                funTransitions();
                if(jqXHR.status == 422){
                    let res = jqXHR.responseJSON.errors;
                    let output = '';
                    $.each(res, function(i, value){
                        output += value + '\n';
                    });
                    sweetMessage('', output, 'warning');
                }
            },
            success: function(data, textStatus, xhr){
                funTransitions();
                $(':input','#create-brand-form').val('');
                $(".select-marca :contains('Seleccione la marca')").remove();
                $('.select-marca').prepend($('<option>',{
                    value: data.marca.id,
                    text: data.marca.nombre
                }));
                $(".select-marca").prepend($('<option>', {
                    value: '',
                    text: 'Seleccione la marca'
                }));
                $('.select-marca').val(data.marca.id);
                $('.select-marca').trigger('change.select2');
                sweetMessage('', data.success);
            }
        });
    });

    $(document).on('change', '#sel_area_option', function(){
        let val=$(this).val();
        dt_product(val);       
    });

    $(document).on('focus', '.precio_venta', function(){
        var t=0;
        let rr=$('#rr').val();
        let cc=$('#cc').val();
        console.log(parseInt(rr),parseInt(cc));
         t = (parseInt(cc) * (100/(100-parseInt(rr))));
        
        $(this).val(parseInt(t));
               
    });


    $(document).on('click', '#save-product-type', function(){
        let funTransitions = function(){
            if(!$('#save-product-type').attr('disabled')){
                $('#save-product-type').attr('disabled', true);
                $('#form-fields-product-type').addClass('d-none');
                $('#spinner-product-type').removeClass('d-none');
            }else{
                $('#save-product-type').attr('disabled', false);
                $('#form-fields-product-type').removeClass('d-none');
                $('#spinner-product-type').addClass('d-none');
            }
        }
        funTransitions();
        let formData = new FormData($('#create-product-type-form')[0]);
        $.ajax({
            url: $('#create-product-type-form').attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            error: function(jqXHR, textStatus, errorThrown){
                funTransitions();
                if(jqXHR.status == 422){
                    let res = JSON.parse(jqXHR.responseText);
                    let output = '';
                    $.each( res, function(i, value){
                        output += value + '\n';
                    });
                    sweetMessage('', output, 'warning');
                }
            },
            success: function(data, textStatus, xhr){
                funTransitions();
                $(':input','#create-product-type-form').val('');
                $(".select-tipo-producto :contains('Seleccione tipo de producto')").remove();
                $('.select-tipo-producto').prepend($('<option>',{
                    value: data.tipo_producto.id,
                    text: data.tipo_producto.descripcion
                }));
                $('.select-tipo-producto').prepend("<option>",{
                    value: '',
                    text:'Seleccione tipo de producto'
                });
                $('.select-tipo-producto').val(data.tipo_producto.id);
                $('.select-tipo-producto').trigger('change.select2');
                sweetMessage('', data.success);
            }
        });
    });


    

   

    $.ajax({
        url: $("#select-product-type-data-url").val(),
        type: "GET",
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        success: function(data, textStatus, xhr){
            $.each(data.tipos_productos, function(i, tipo_producto){
                var newOption = new Option(tipo_producto.descripcion, tipo_producto.id, false, false);
                $('.select-tipo-producto').append(newOption).trigger('change');
            });
            if($('#old-select-product-type').length){
                $('.select-tipo-producto').val($('#old-select-product-type').val());
                $('.select-tipo-producto').trigger('change.select2');
            }
        }
    });

    

   
});







