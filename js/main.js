jQuery(document).ready(function($){
    const movieSortList = $('ul.movie-sort-list');
    const loading = $('.loading');
    const orderSaveMsg = $('.order-save-msg');
    const orderSaveErr = $('.order-save-err');

    movieSortList.sortable({
        update: function(e, ui){
            loading.show();

            $.ajax({
                url: ajaxurl,
                type: 'post',
                dataType: 'json',
                data:{
                    action: 'save_order',
                    order: movieSortList.sortable('toArray'),
                    token: ML_MOVIE_LISTING.token
                },
                success: function(res){
                    loading.hide();
                    if(true === res.success){
                        orderSaveMsg.show();
                        setTimeout(function(){
                            orderSaveMsg.hide();
                        }, 2000);
                    } else {
                        orderSaveErr.show();
                        setTimeout(function(){
                            orderSaveErr.hide();
                        }, 2000);
                    }
                },
                error: function(err){
                    orderSaveErr.show();
                    setTimeout(function(){
                        orderSaveErr.hide();
                    }, 2000);
                }
            });
        }
    });
});