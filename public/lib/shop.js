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

// Number of products shown by page
let numOfShowedProducts = 15;

// An array that contains several arrays that represent the pages
let listedProductsByPage;

// Current page listed
let currentPage = 0;

// An auxiliary array that contains the products from the current page
let listedProducts;

let orderArray = function(array, type){
    if(type == 1){
        array.sort((a, b) => a.created_at - b.created_at);
        array.reverse();
    }else if(type == 2){
        array.sort((a, b) => a.descuento - b.descuento);
        array.reverse();
    }
    return array;
}

let previous = $('<li>',{
    class: 'page-item disabled',
    html: $('<a>', {
        class: 'page-link page-btn-move',
        'arial-label': 'Anterior',
        'data-value' : -1,
        id: 'previous-nav',
        html: '<span aria-hidden="true">&laquo;</span><span class="sr-only">Anterior</span>'
    })
});
let next = (numOfShowedPages) => $('<li>',{
    class: 'page-item ' + ((currentPage == (numOfShowedPages-1))? 'disabled' : ''),
    html: $('<a>', {
        class: 'page-link page-btn-move',
        'arial-label': 'Siguiente',
        'data-value': 1,
        id: 'next-nav',
        html: '<span aria-hidden="true">&raquo;</span><span class="sr-only">Siguiente</span>'
    })
});

let nav;

let printNavButtons = function(){
    let numOfShowedPages = listedProductsByPage.length;
    nav = $('<nav>', {
        'aria-label':'Page navigation',
        html: $('<ul>',{
            class: 'pagination justify-content-center mb-3',
            html: function(){
                let aux = $('<div>').append(previous);
                for(let i = 0; i < numOfShowedPages; i++){
                    aux.append(
                        $('<li>', {
                            class: 'page-item ' + ((i == currentPage)? 'active' : ''),
                            id : 'li-' + i,
                            html: '<a class="page-link page-btn" data-page="' + i + '">' + (i+1) + '</a>'
                        })
                    );
                }
                aux.append(next(numOfShowedPages));
                return aux.html();
            }
        })
    });

    $('#page-navigation').html(nav);
}

$(document).on('click', '.page-btn', function(){
    if($(this).data('page') != currentPage){
        currentPage = $(this).data('page');
        listProducts();
        refreshActivePage();
    }
});

$(document).on('click', '.page-btn-move', function(){
    currentPage += parseInt($(this).data('value'));
    listProducts();
    refreshActivePage();
});

let refreshActivePage = function(){
    let numOfShowedPages = listedProductsByPage.length;
    nav.find('.active').removeClass('active');
    $('#li-' + currentPage).addClass('active');
    if(currentPage != 0 && $('#previous-nav').parent().hasClass('disabled')){
        $('#previous-nav').parent().removeClass('disabled');
    }else if(currentPage == 0 && !$('#previous-nav').parent().hasClass('disabled')){
        $('#previous-nav').parent().addClass('disabled');
    }
    if(currentPage != numOfShowedPages-1 && $('#next-nav').parent().hasClass('disabled')){
        $('#next-nav').parent().removeClass('disabled');
    }else if(currentPage == numOfShowedPages-1 && !$('#next-nav').parent().hasClass('disabled')){
        $('#next-nav').parent().addClass('disabled');
    }
}

let setPages = function(orderType = 0, filteredArray = null){
    let index = 0;
    let countProducts = 0;
    let allProductsAux = (filteredArray != null)? filteredArray : allProducts;

    listedProductsByPage = [];
    listedProductsByPage[index] = [];

    if(orderType != 0){
        allProductsAux = orderArray(allProductsAux, orderType);
    }
    $.each(allProductsAux, function(i, product){
        if(countProducts < numOfShowedProducts){
            countProducts++;
        }else{
            index++;
            listedProductsByPage[index] = [];
            countProducts = 1;
        }
        listedProductsByPage[index].push(product);
    });

    printNavButtons();
}

setPages();

$('.numOfListedElements').on('click', function(){
    numOfShowedProducts = parseInt($(this).data('value'));
    categoryFilter();
    listProducts();
});

// Ordering products
$(document).on('click', '.orderBy', function(){
    let value = $(this).data('value');
    setPages(value);
    listProducts();
});

// Searching products
$(document).on('keyup', '#searchProduct', function(event){
    searchProduct(event);
});

function searchProduct(event){
    if(event.which == 13 && $('#searchProduct').val() != ''){
        let value = $('#searchProduct').val().toLowerCase();
        let auxListedProducts = [];
        $.each(allProducts, function(i, product){
            if(product.titulo.toLowerCase().includes(value) || product.category.titulo.toLowerCase().includes(value))
                auxListedProducts.push(product);
        });
        if(auxListedProducts.length != 0){
            setPages(0, auxListedProducts);
            listProducts();
        }else{
            $('#products-list').html('<div class="col-12 text-center mb-5">No se encontraron resultados para la busqueda.</div>');
            $('#page-navigation').html('');
        }
    }else if($('#searchProduct').val() == ''){
        categoryFilter();
        listProducts();
    }
}

let refreshDiscountFilter = function(){
    $('#discount-filter').html('');
    let div = '';
    let allQuantity = 0;
    $.each(discounts, function(i, v){
        let count = 0;
        $.each(listedProductsByPage, function(i, listedProducts){
            $.each(listedProducts, function(j, product){
                if(product.descuento && v[0] <= product.descuento && v[1] >= product.descuento){
                    count++;
                    allQuantity++;
                }
            });
        });
        if (count != 0) {
            div += discountInput(i, v[2], count).get(0).outerHTML;
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
        $('#discount-filter').append(discountInput('none', -1, allQuantity, true).get(0).outerHTML);
    }else{
        $('#discount-filter').append($('<p>').text('Proximamente tendremos m\u00e1s ofertas'));
    }
}

let discountInput = function(id, text, quantity, displayNone = false){
    return $('<div>', {
        class: "custom-control custom-radio d-flex align-items-center justify-content-between mb-3",
        html: [
            $('<input>',{
                type: 'radio',
                name: 'offer',
                class: 'custom-control-input radio-offer',
                id: 'radio-offer-' + id,
                value: id,
                checked: displayNone
            }),
            '<label class="custom-control-label" for="radio-offer-' + id + '">' + text + '</label>',
            '<span class="badge border font-weight-normal">' + quantity + '</span>'
        ],
        style: ((displayNone)?'display:none !important' : '')
    });
}

refreshDiscountFilter();

$(document).on('click', '#clear-discount-filter', function(){
    $('.radio-offer:checked').prop("checked", false);
    categoryFilter();
    listProducts();
});

let listProducts = function(){
    listedProducts = listedProductsByPage[currentPage];
    $('#products-list').html('');
    $.each(listedProducts, function(i, product){
        let offerTag;
        if(product.descuento && product.descuento > 0){
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
                                text: product.descuento + '%'
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
                                        src: product.imagen
                                    })
                                ]
                            }),
                            $('<div>', {
                                class: 'card-body border-left border-right text-center p-0 pt-4 pb-3',
                                html: '<h6 class="text-truncate mb-3">' + product.titulo + '</h6>'
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
$(document).on('change', '.radio-category', function(){
    categoryFilter();
    listProducts();
});

let categoryFilter = function(){
    listedProducts = [];
    currentPage = 0;
    let checked_category = $('.radio-category:checked').val();
    if(checked_category != -1){
        $.each(allProducts, function(i, product){
            if(checked_category == product.categorias_id){
                listedProducts.push(product);
            }
        });
    }else{
        listedProducts = allProducts;
    }
    setPages(0, listedProducts);
    refreshDiscountFilter();
}

let discountFilter = function(){
    let checked_offer = $('.radio-offer:checked').val();
    if(checked_offer != 'none'){
        let list_aux = [];
        if(typeof checked_offer !== "undefined"){
            $.each(listedProductsByPage, function(j, products){
                $.each(products, function(i, product){
                    if((product.descuento && (discounts[checked_offer][0] <= product.descuento && discounts[checked_offer][1] >= product.descuento))){
                        list_aux.push(product);
                    }
                });
            });
        }
        if(list_aux.length != 0)
            listedProducts = list_aux;
        setPages(0, listedProducts);
    }
}

$(document).on('change', '.radio-offer', function(){
    let radio = $(this).val();
    categoryFilter();
    $('.radio-offer[value="' + radio + '"]').attr('checked', true);
    discountFilter();
    listProducts();
});

if(typeof byCategory !== "undefined"){
    $('#radio-category-' + byCategory).click();
}

if(typeof search !== "undefined"){
    $('#searchProduct').val(search);
    searchProduct(jQuery.Event('keyup', {which: 13}));
}