jQuery(document).ready(function(){

    jQuery('#save').on('click' , function(){
        
        alert("hello");
        console.log(boiler_ajax_url);

        var arr = new Array();
        var get_post = jQuery('.all_post:checked').length;
        
        alert(get_post);

        if(get_post>0){

            jQuery('.all_post:checked').each(function(){

                arr.push(jQuery(this).val());

            });
            alert(arr);            
        }

        jQuery.ajax({
            url: boiler_ajax_url.ajax_url,
            type: 'post',
            data: {
                'action':'meta_ajax',
                arr : arr
            },
            success: function( response ) {
               alert("updated successfully");
            },
        });



    });
});
    


