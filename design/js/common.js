

//intro Class
var mainClass = function(){

    this.init = function(){
        $('.ajax-gift').click(gift_ajax);
        $('#search').click(search);
    }

}


function search()
{
    var pid  = $('input[name="search_id"').val();
    $.ajax({
        url: 'users/search',
        data: { pid : pid },
        type: "GET",
        dataType: "json",
        success: function(data){

            user   =  '<td><img src="'+ data.image+'" width="30"/></td>';
            user +=  '<td>'+data.name+'</td>';
            user +=  '<td>'+data.pid+'</td>';
            user +=  '<td><button class="ajax-gift" data-id='+data.pid+'>Дать подарок</button></td>';
            user   = '<tr>'+user+'</tr>';

            $('table.users').append(user);
        }
    });
}
function gift_ajax() {

    var pid = $(this).attr('data-id');

    $.ajax({
        url: 'users/gift',
        data: { pid : pid },
        type: "GET",
        dataType: "html",
        success: function(data){
            alert(data);
        }
    });
}

function hash_load(){
    var hash = window.location.hash.substr(1);
    if(hash == 'profile')
        profile();
}

function rand(k){
   return Math.floor((Math.random()*k)+1);
}


$(document).ready(function(){
    
    main = new mainClass();

    main.init();

    $.ajaxSetup({ cache: false });

    $(window).resize();
      
}); 


