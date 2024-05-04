// Filters for discount
let discounts = [
    [1, 100, 'Todos los descuentos'],
    [1, 10, '1% - 10%'],
    [11, 20, '11% - 20%'],
    [21, 30, '21% - 30%'],
    [31, 40, '31% - 40%'],
    [41, 50, '41% - 50%'],
    [51, 100, '51% - 100%']
];

// All products showed
let listedProducts = allProducts;

let refresh_discount_filter = function(){
    $('#discount-filter').html('');
    let div = '';
    let allQuantity = 0;
    $.each(discounts, function(i, v){
        let count = 0;
        $.each(listedProducts, function(i, product){
            if(product.discount && v[0] <= product.discount && v[1] >= product.discount){
                count++;
                allQuantity++;
            }
        });
        if (count != 0) {
            div += discount_input(i, v[2], count).get(0).outerHTML;
        }
    });
    
    if(allQuantity != 0){
        $('#discount-filter').append($('<button>', {
            type : "button",
            class: 'btn btn-link',
            text: 'Limpiar filtro',
            id: 'clear-discount-filter'
        }));
        $('#discount-filter').append(div);
    }else{
        $('#discount-filter').append($('<p>').text('Proximamente tendremos m\u00e1s ofertas'));
    }
}

let discount_input = function(id, text, quantity){
    return $('<div>', {
        class: "custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3",
        html: [
            $('<input>',{
                type: 'radio',
                name: 'offer',
                class: 'custom-control-input radio-offer',
                id: 'radio-offer-' + id,
                value: id
            }),
            '<label class="custom-control-label" for="radio-offer-' + id + '">' + text + '</label>',
            '<span class="badge border font-weight-normal">' + quantity + '</span>'
        ]
    });
}

refresh_discount_filter();

$(document).on('click', '#clear-discount-filter', function(){
    $('.radio-offer:checked').prop("checked", false);
    listProducts();
});

let listProducts = function(){
    $('#products-list').html('');
    $.each(listedProducts, function(i, product){
        let offerTag;
        if(product.discount && product.discount > 0){
            offerTag = $('<p>', {
                class: 'text-right w-100 position-absolute',
                html: $('<span>', {
                    class: 'fa-stack fa-2x',
                    html: [
                        $('<i>', {
                            class: 'fas fa-certificate fa-stack-2x text-danger'
                        }),
                        $('<span>', {
                            class: 'fa fa-stack-1x text-light',
                            html: $('<span>', {
                                class: 'align-top',
                                style: 'font-size: 0.7em;',
                                text: product.discount + '%'
                            })
                        })
                    ]
                })
            });
        }
        $('#products-list').append(
            $('<div>', {
                class: 'col-lg-4 col-md-6 col-sm-12 pb-1',
                html: $('<div>', {
                        class: 'card product-item border-0 mb-4',
                        html: [
                            $('<div>', {
                                class: 'card-header product-img position-relative overflow-hidden bg-transparent border p-0',
                                html: [
                                    offerTag,
                                    $('<img>',{
                                        class: 'img-fluid w-100',
                                        src: product.img
                                    })
                                ]
                            }),
                            $('<div>', {
                                class: 'card-body border-left border-right text-center p-0 pt-4 pb-3',
                                html: '<h6 class="text-truncate mb-3">' + product.name + '</h6>'
                            }),
                            $('<div>', {
                                class: 'card-footer d-flex justify-content-center bg-light border',
                                html: '<a href="' + product.route + '" class="btn btn-sm text-dark p-0">'
                                + '<i class="fas fa-eye text-primary mr-1"></i>Ver m&aacute;s</a>'
                            }),
                        ]
                    })
            })
        );
    });
}

listProducts();

// Category filter
$('.radio-category').change(function(){
    listedProducts = [];
    let checked_category = $(this).val();
    $.each(allProducts, async function(i, product){
        if(checked_category == product.category || checked_category == -1){
            listedProducts.push(product);
        }
    });
    refresh_discount_filter();
    discount_filter();
});

let discount_filter = function(){
    let checked_offer = $('.radio-offer:checked').val();
    let list_aux = [];
    if(typeof checked_offer !== "undefined"){
        $.each(listedProducts, function(i, product){
            if((product.discount && (discounts[checked_offer][0] <= product.discount && discounts[checked_offer][1] >= product.discount))){
                list_aux.push(product);
            }
        });
    }
    let aux_listedProducts = listedProducts;
    if(list_aux.length != 0)
        listedProducts = list_aux;
    listProducts();
    listedProducts = aux_listedProducts;
}

$(document).on('change', '.radio-offer', function(){
    discount_filter();
});

if(typeof byCategory !== "undefined"){
    $('#radio-category-' + byCategory).click();
}