    
mode     = 'main';
shareImg = 'mag';

function get_photos()
{
    var loadMess = $('#load-mess');
    
    $.ajax({
        url: '/ajax.php',
        data: {module: 'get_photos'},
        type: "GET",
        dataType: "html",
        beforeSend: function(){ loadMess.fadeIn(200)},
        success: function(data){
            if(data)
            {
                $('.content, .profile-content').append(data);  
                setTimeout(function(){
                    $('.item:hidden').fadeIn(300);
                    shape_init($(".content")); 
                    check_gift();
                },300);     
            }
                    
            loadMess.fadeOut(200);
        }
	});
} 

function show_login()
{
    $.fancybox('<img src="/design/img/login-image.png"/> <div class="clear"></div> <div class="login-btns"><div><span>Ввійти через:</span><div class="s"><a href="/auth/vk/" class="vk active ">Vkontakte</a><a href="/auth/fb/" class="fb active ">Facebook</a></div></div></div>',{
        tpl: {
        	wrap : '<div class="fancybox-login" tabIndex="-1"> <div class="fancybox-outer"><div class="fancybox-inner"></div></div> </div>'
        },
        closeBtn : false,
        width: 750
    }); 
}



function get_count()
{
    $.ajax({
        url: '/ajax.php',
        data: {module: 'get_count'},
        type: "GET",
        dataType: "html",
        success: function(data){
            if(data){
                alert(data);
            }
        }
	});
}
function del_social()
{
    var loader = new Image;
    var addIm  = new Image;
    loader.src = '/design/img/loader-small.gif';
    addIm.src  = '/design/img/add.png';
    
    $this = $(this);
    $this.html(loader);
    
    delId = $this.attr('data-soc-id');
    
    $.ajax({
        url: '/ajax.php',
        data: {module: 'delete_social', id: delId},
        type: "GET",
        dataType: "json",
        success: function(data){
            if(data.status){
                $('.s a.'+data.social).removeClass('del-soc active').attr("href", "/auth/"+data.social+"/join");
                $('.s .path.'+data.social).addClass('dis');
                $this.html(addIm);
            }    
            else if(data.msg)
            {
                alert(data.msg);
                $this.html('');
            }
        }
	});   
}

function position()
{
    fancybox_position();
    
    win_h = $(window).height();
    win_w = $(window).width();
    
    if(win_h < 800) 
    {
        $('.profile-wrap').css({'height': win_h-20, 'margin-top': -(win_h-20)/2});
        $('.scrolled').css({'overflow-y': 'auto', 'height': win_h-120});
    }
    else
    {
        $('.scrolled').attr('style','');
        $('.profile-wrap').css({'height': 800, 'margin-top': -400});
    }
    $('.wrapper').height(win_h);
    $('.container').height(win_h);
    $('.content').css('padding-bottom',(win_h*0.6));
}


function getCookie(name) 
{
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));

  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name,value)
{
    var date = new Date( new Date().getTime() + 60*60*24*14*1000);
    document.cookie=name+"="+value+"; expires="+date.toUTCString();
}


function delCookie(name){
    var date = new Date(0);
    document.cookie=name+"=; expires="+date.toUTCString(); 
}

function like()
{
    var $this = $(this);
    var loader = $this.parent().parent().find('.wait');
    
    id    = $this.attr('data-id');
    topL  = $this.position().top;
    leftL = $this.position().left;
    
    if(!id)
        return false;
    
    $this.hide();
    loader.css({"position": "absolute", top:topL+7, left:leftL+7}).show();
    
    $.ajax({
        url: '/ajax.php',
        data: {module: 'like', id: id},
        type: "GET",
        dataType: "html",
        success: function(data){
            
            if(data == 'true'){
                loader.hide();
                $this.addClass('disable').attr('data-id','').show();
            }
            else if(data == 'login'){
                show_login();
                $this.show();
                loader.hide();
            }
            else {
                loader.hide();
                $this.show();
            }
            
        }
	});
}

function like_big()
{
    var $this = $(this);
    var loader = $this.parent().find('.wait');
    
    id    = $this.attr('data-id');
    topL  = $this.position().top;
    leftL = $this.position().left;
    
    if(!id)
        return false;
    
    $this.hide();
    loader.css({"position": "absolute", top:topL+13, left:leftL+13}).show();
    
    $.ajax({
        url: '/ajax.php',
        data: {module: 'like', id: id},
        type: "GET",
        dataType: "html",
        success: function(data){
            if(data == 'true')
            {
                loader.hide();
                $this.addClass('disable').attr('data-id','').show();
                $('.like[data-id="'+id+'"]').addClass('disable').attr('data-id','');
            }
            else if(data == 'login'){
                show_login();
                $this.show();
                loader.hide();
            }
            else {
                loader.hide();
                $this.show();
            }
            
        }
	});
}

function look()
{
    
    var src  = $.fancybox.current.href; 
    var a    = $('a[href="'+src+'"]');

    var item   = a.parent(); 
    itemId = a.attr('data-id'); 
    path   = a.find('img:not(.winned)').attr('src');

    $('.i-users span').html(a.parent().find('.an').html());
    
    if(item.find('.like').hasClass('disable'))
        $('.fancybox-header .like').attr('data-id','').addClass('disable');
    else
        $('.fancybox-header .like').removeClass('disable').attr('data-id',itemId);
        
    if(item.attr('data-status') == 1)
        $('.fancybox-inner .win').show(); 
    else
        $('.fancybox-inner .win').hide();
    
    if(item.find('.look-bar').length == 0){
        var hide = true;
    } else {
        var hide = false;
    }
       
    $.ajax({
        url: '/ajax.php',
        data: {module: 'look', id: itemId, src: path},
        type: "GET", 
        cache: false,
        dataType: "JSON",
        success: function(data){
            item.find('.look-bar div').html(data.looks);
            $('.fancybox-header .look-bar div').html(data.looks).parent().show();        
            $('.i-users img.avatar').attr('src',data.avatar);
            $('.fancybox-skin .social').addClass(data.social);    
        }
	});
    
}

function fancybox_position()
{
    setTimeout(function(){
        var inner = $('.fancybox-inner');
        var image = $('.fancybox-image');
        image.css({'padding-top':((inner.height()-image.height())/2)}).fadeIn(200);
    },300);

}

function profile()
{   
    if(!getCookie('promptShowProfile')){
         setTimeout(function(){
                prompt.init('profile');
                setCookie('promptShowProfile','true');
                prompt.visible = true;
         },1000);  
     }   
    
    mode = 'profile';
    
    var wind = $('.profile-wrap, #fade');
    
    wind.show();
    
    shape_init($(".profile-content"));
          
    $('.close').click(function(){
        wind.hide();    
    });    
}

function swPage()
{   
    var page = $(this).attr('data-page'); 
    
    $('.page').hide();
    $('.'+page).show();
   
    if(page == 'profile-images')
        shape_init($(".profile-content"));
    
    if(page == 'profile-croper')
        croper_init();   
    else
        croper_del();   
        
    if(page == 'profile-form')
        $('form#delivery-form').find('input[name="type"]').val($(this).attr('data-type'));

}

function show_images_page()
{
    $('.page, .error-msg').hide();
    $('.profile-images').show();
}

function show_croper_page()
{
    $('.page, .error-msg').hide();
    $('.profile-croper').show();
    croper_init();
}


function show_share_page(type)
{
    shareImg = type;
    $('.share-wrp img').attr('src','/design/img/share-'+type+'.png');
    
    $('.page').hide();
    $('.profile-share').show();
}


function shape_init(cont)
{
    cont.shapeshift({
        enableDrag: false,
        gutterX: 15,
        gutterY: 15
    });
}


function croper_init()
{
    $('#img').imgAreaSelect({
        minWidth: 300, 
        minHeight: 300, 
        aspectRatio: '1:1', 
        x1: 10, 
        y1: 10, 
        x2: 310, 
        y2: 310, 
        handles: true,
        onSelectEnd: function (img, selection) {
            $('input[name="x1"]').val(selection.x1);
            $('input[name="y1"]').val(selection.y1);
            $('input[name="x2"]').val(selection.x2);
            $('input[name="y2"]').val(selection.y2);            
        }
    });
    
    var logo = new Image;
    logo.src = "/design/img/lipton-logo.png";
    logo.height = 60;
    logo.setAttribute("style","position:absolute; top:5px; right:5px;");
    
    $('.imgareaselect-selection').append(logo);    
}

function croper_del()
{
    $('#img').imgAreaSelect({remove:true});
}


function send_win_image(data,type)
{
    var error_cont = $('.error-msg');
    
    $.ajax({
        url: '/ajax.php',
        data: {module: 'send_win_image', data: data},
        type: "POST",
        dataType: "JSON",
        success: function(image){
            if(image.path)
            {
                $('#img').attr('src',image.path);
                $('input[name="img_id"]').val(image.id);
                $('#mag-count').html(image.count);
                show_share_page(type);
            }
            else if(image.end)
            {
                $('.profile-gifts-item.mag').addClass('disable');
                show_share_page(type);
            }
            else
                error_cont.html(image.msg).fadeIn(200);               
        }
	});
}


function send_user_data(formData,type)
{    
    var error_cont = $('.error-msg');
    
    $.ajax({
        url: '/ajax.php',
        data: {module: 'send_user_data', data: formData},
        type: "POST",
        dataType: "JSON",
        success: function(data){
            if(data.status)
            {
                $('.profile-gifts-item.'+type).addClass('disable');   
                show_share_page(type);
            }
            else
                error_cont.html(data.msg).fadeIn(200);               
        }
	});
}

p = 0;
currTop = $(window).height()/2;
function ajax_content($this)
{   
    var top = $this.scrollTop();  
    if( top > currTop) 
    {
        currTop = currTop + $(window).height();
        p++;
        $.ajax({
            url: '/ajax.php',
            data: {module:'scroll_images', page: p},
            type: "POST",
            beforeSend: function(){ $('.content-loader').show()},
            dataType: "html",
            success: function(data){
                if(data)
                {
                    $('.content').append(data);  
                    setTimeout(function(){
                        $('.item:hidden').fadeIn(300);
                        shape_init($(".content")); 
                    },300); 
                }
                else
                    $('.content').css('padding-bottom',100);
                    
                $('.content-loader').hide();
                            
            }
    	});
    }
}


function gift_img_on(){
    $(this).stop(true,true).find('a img, .i').fadeTo(200,0);
    
    if($(this).find('.soc').length == 0)
        $(this).append("<div class='soc vk'></div> <div class='soc fb'></div>");
}

function gift_img_off(){
    $(this).find('a img, .i').stop(true,true).fadeTo(200,1);
    $(this).find('.soc').remove();
}


function share()
{   
    var socType = $(this).attr('class').replace("soc ", "");

    if(socType == 'vk')
    {
        VK.api('wall.post', {owner_id : 7793304, message : 'test', attachments : 'http://www.fbrell.com/public/f8.jpg' }, 
        
        function(data)
        {    
            if(data.response)
            {
                console.log(data);
            }
        });
    } 
    else
    {
        FB.ui({
            method: 'feed',
            name: 'The Facebook SDK for Javascript',
            caption: 'Bringing Facebook to the desktop and mobile web',
            description: (
              'A small JavaScript library that allows you to harness ' +
              'the power of Facebook, bringing the user\'s identity, ' +
              'social graph and distribution power to your site.'
            ),
            link: 'http://lipton.tribalddb.com.ua/',
            picture: 'http://www.fbrell.com/public/f8.jpg'
            },
            function(response) {
            if (response && response.post_id) {
              console.log(response);
            } else {
              alert('Post was not published.');
            }
            }
        );
    }      
   
}

function hash_load(){
    var hash = window.location.hash.substr(1);
    if(hash == 'profile')
        profile();
}

function rand(k){
   return Math.floor((Math.random()*k)+1);
}


//prompt Class
var promptClass = function(){
     
    var item   =  {
        fade     : $('#prompt-fade'), 
        avatar   : $('#prompt-avatar'),
        button   : $('#prompt-button'),
        social   : $('#prompt-social'),
        socialP  : $('#prompt-social-profile'),
        like     : $('#prompt-like'),
        gifts    : $('#prompt-gifts'),
        closeBtn : $('#prompt-close')
    };
    
    var target =  {
        avatar   : $('.header > .u > .avatar'),
        button   : $('.btn-how'),
        button2  : $('.profile-data button.btn'),
        social   : $('.header > .s > a.vk'),
        socialP  : $('.profile-data > .s > a.vk'),
        like     : $('.content .item:eq(3)'),
        like2    : $('.content .item:eq(2)')             
    };
    
    
    this.visible = false;
    
    this.init = function(mode){

        items = [];
        
        if(mode == 'main'){
            
            var avatarPosition = target.avatar.offset();
            var buttonPosition = target.button.offset();
            var socialPosition = target.social.offset();
            var likePosition   = ($(window).width() < 1113)? target.like2.offset() : target.like.offset();
    
            var items = [
                item.social.css({top : socialPosition.top - 22,  left : socialPosition.left - 380 }),
                item.avatar.css({top : avatarPosition.top - 20,  left : avatarPosition.left - 80  }),
                item.like.css({  top : likePosition.top   + 50,  left : likePosition.left   - 190 }),
                item.button.css({top : buttonPosition.top - 145, left : buttonPosition.left - 20  }),
                item.closeBtn
            ];
        
        } else if(mode == 'profile') {
            
            var buttonPosition = target.button2.offset();
            var socialPosition = target.socialP.offset();
            
            var items = [
                item.socialP.css({top : socialPosition.top - 38,  left : socialPosition.left - 5  }),
                item.gifts.css({  top : buttonPosition.top - 140, left : buttonPosition.left - 33 }),
                item.closeBtn
            ];
            
        } else if(mode == 'hidden'){
            return false;
        }
        
        item.fade.show();
        this.showItems(items);
    }
    
    
    
    this.showItems = function(items){
        items.forEach(function(item,i){
            if(item.is(':hidden')){
                item.delay(1500*i).fadeIn(500);
            }
        });
    }
    
    
    
    this.hideItems = function(){
        $('.prompt, #prompt-fade').hide();
        this.visible = false;
    }
    
}
 
//intro Class
var introClass = function(){
    
    var fade = $('#prompt-fade');
    var cont = $('#intro-cont');
    
    this.init = function(){
        fade.fadeIn(200);
        cont.fadeIn(200);
        
        $('.guest-login').click(this.hide);
    }
    
    this.hide = function(){
        fade.fadeOut(200);
        cont.fadeOut(200);
    }
}



$(document).ready(function(){
    
    prompt = new promptClass();
    intro  = new introClass();
    
    VK.init({apiId: 3895824});
    $.ajaxSetup({ cache: false });
    
    get_photos();
    get_count();
    
    $('body').on('click','.item .like:not(.diasble)',like);   
    $('body').on('click','.fancybox-wrap2 .like:not(.diasble)',like_big);   
    $('body').on('click','.u .avatar', profile);
    $('.content').on('mouseenter','.item.g',gift_img_on);
    $('.content').on('mouseleave','.item.g',gift_img_off);
    $('.content').on('click','.item.g .soc',share);
    
    
    $('.profile-content .item a').click(function(){return false;});
    $('.profile-data .avatar').click(show_images_page);
    $('.del-soc').click(del_social);
    $('button.btn').click(swPage);
    $('#prompt-close').click(function(){prompt.hideItems()});
    
    $(".content .item a").fancybox({
        beforeShow  : look,
        afterShow   : fancybox_position,
        openEffect  : 'none',
        closeEffect : 'none',
        fitToView	: false,
        padding     : [0,0,10,0],
        minWidth    : 500,
        autoSize    : false,
        tpl: {
        	wrap  : '<div class="fancybox-wrap2 popup" tabIndex="-1"> <div class="fancybox-skin"> <div class="fancybox-header"> <div class="i-users"><img class="avatar" src="" width="50" height="50"><span></span></div> <div class="isb"><div class="look-bar"><div>0</div></div><a class="like" data-id=""></a> <img class="wait" src="/design/img/loader-small.gif"> </div></div> <div class="fancybox-outer"><div class="fancybox-inner"><img class="win" src="/design/img/win.png"/></div></div><div class="social"></div> </div></div>'
        }
    });
    
    $(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
        padding     : [0,0,10,0],
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
        tpl: {
        	wrap  : '<div class="fancybox-wrap3 popup" tabIndex="-1"> <div class="fancybox-skin"> <div class="fancybox-header"> <span>Правила Акції</span> </div> <div class="fancybox-outer"><div class="fancybox-inner"></div></div> </div></div>'
        }
	});
    
    $(".winners").fancybox({
        maxWidth	: 850,
        padding     : [0,0,10,0],
		fitToView	: false,
		width		: '80%',
        height		: '90%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
        tpl: {
        	wrap  : '<div class="fancybox-wrap4 popup" tabIndex="-1"> <div class="fancybox-skin"><div class="fancybox-header"> <span>Переможці <i>1</i>-ї неділі </span> </div> <div class="fancybox-outer"><div class="fancybox-inner"></div></div></div> </div>'
        }
	});
    

    $(window).resize(function(){
        position();
        
        if(prompt.visible){
            prompt.init(mode);
        }
    });
    
    setTimeout(function(){
        $(".content").fadeIn(200);
        shape_init($(".content")); 
        $('.content-loader').addClass('bottom');   
    },500);
    
     
    position();
    
    $('input[type="checkbox"]').form_style();
    
    $('.container').scroll(function(){
        
        ajax_content($(this));
        
        if($(this).scrollTop()>150) 
        {
            var uc = $('.u').clone();
            
            if( $('.u.mod').length > 0)
                return;
            else
                $('.wrapper').append(uc.addClass('mod')); 
        }
        else 
            $('.u.mod').remove();
    });
    
    
	$('#name, #city').keyup(function(){
		$(this).val($(this).val().replace(/\d/gi, ''));
	});
    
	$('#tel, #index').keyup(function(){
        $(this).val($(this).val().replace(/[A-Za-z$-]/g, ""));
	});
    
	$('#delivery-form').submit(function(e){
        e.preventDefault();
		var checked = true;
        
        $('#delivery-form input').css({border : '1px solid #e4e4e4'});
		$('#delivery-form input').each(function(i, e) {
			
            if(($(this).val() == '') || ($(this).attr('id') == 'email' && (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test($(this).val()))) ) {
				checked = false;
				$(this).css({border : '1px solid #E67777'});
			}
            
            if($(this).is(':checkbox') && !$(this).prop("checked") )
           	    checked = false;
                
		}).click(function() {
			$(this).css({border : '1px solid #e4e4e4'});
		});
		if(!checked){
			e.preventDefault();
            return false;
		} else {
		      
            var type = $(this).find('input[name="type"]').val();
            
            if(type == 'mag')
                send_win_image($(this).serialize(),type);
            else
                send_user_data($(this).serialize(),type);  
		}
	});
    
    //Загрузка фотографии
    $('#imageFile').change(function(){ 
        
        var error_cont = $('.error-msg');
        var loader = $('.loader');
        var next = $('#next');
        var upload = $('#upload');
        
        $("#image-form").ajaxForm({
            url: '/ajax.php',
            data:{ module:'upload_file'},
            dataType:'JSON',
            resetForm: true,
            beforeSubmit:  function(){ loader.show();},
            success: function(data){
                
                loader.hide();
                if(data.status)
                {
                    $('#img').attr('src',data.image);
                    error_cont.html('').hide();
                    next.show();
                    upload.val('true');
                }
                else{
                    error_cont.html(data.msg).fadeIn(200);   
                    next.hide(); 
                }
                       
            }
        }).submit();
    });
    
    //Обрезка фотографии
    $("#image-area-form").on('submit',function(e) {
        e.preventDefault();
        var error_cont = $('.error-msg');
        
        $(this).ajaxSubmit({
            url: '/ajax.php',
            dataType:'JSON',
            data: {module:'cut_image'},
            success: function(data){
                if(data.status)
                {
                    croper_del();
                    $('#preview').find('img').attr('src',data.image);
                    $('.page').hide();
                    $('.profile-preview').show();
                }   
                else
                    error_cont.html(data.msg).fadeIn(200); 
            }
        });
    });
    
    
      
}); 


