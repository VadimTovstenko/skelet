var mainClass = function(){

    this.init = function(){
        $('.container').on('click','.ajax-gift', gift_ajax);
        $('.container').on('click', '.ajax-gift-mag', gift_mag_ajax);
        $('#search').on('click',search);
        $('#search-image').on('click',search_image);
    }

}


function search()
{
    var pid  = $('input[name="search_id"').val();
    $.ajax({
        url: '/users/search',
        data: { pid : pid },
        type: "GET",
        dataType: "json",
        success: function(data){

            user   =  '<td><img src="'+ data.image+'" width="30"/></td>';
            user +=  '<td>'+data.name+'</td>';
            user +=  '<td>'+data.pid+'</td>';
            user +=  '<td><button class="ajax-gift" data-id='+data.pid+'>���� ����</button></td>';
            user   = '<tr>'+user+'</tr>';

            $('table.users').append(user);
        }
    });
}



function search_image()
{
    var sid  = $('input[name="search_id"').val();
    $.ajax({
        url: '/users/searchMag',
        data: { sid : sid },
        type: "GET",
        dataType: "json",
        success: function(data){

            user   =  '<td><img src="'+ data.image+'" width="100"/></td>';
            user +=  '<td>'+data.sid+'</td>';
            user +=  '<td><button class="ajax-gift-mag" data-id='+data.sid+'>���� ������</button></td>';
            user   = '<tr>'+user+'</tr>';

            $('table.users').append(user);
        }
    });
}


function gift_ajax() {

    var pid = $(this).attr('data-id');

    $.ajax({
        url: '/users/gift',
        data: { pid : pid },
        type: "GET",
        dataType: "html",
        success: function(data){
            alert(data);
        }
    });
}



function gift_mag_ajax() {

    var sid = $(this).attr('data-id');

    $.ajax({
        url: '/users/mag',
        data: { sid : sid },
        type: "GET",
        dataType: "html",
        success: function(data){
            alert(data);
        }
    });
}



$(document).ready(function(){

    main = new mainClass();

    main.init();

    $.ajaxSetup({ cache: false });

    $(window).resize();

//-------------------------------------------------//    
// �������� ��� ����� � �������
//-------------------------------------------------//
    $(".input_form, #mainMenu").animate({opacity: '1'}, 600,
        function(){
        $(".statistic").animate({opacity: '1', marginTop:'50'}, 600);
    });
    
//-------------------------------------------------//    
// ��������� ��������� ����
//-------------------------------------------------//
    $('.jqueryslidemenu a').each(function () {    
        var location = window.location.href 
        var link = this.href                
        var result = location.match(link);  

        if(result != null) {               
            $(this).addClass('current'); 
        }
    });
    
//-------------------------------------------------//    
// ������ "���������"
//-------------------------------------------------//
    $('a#save').click(function(){
        $('#add_edit_form').submit(); 
        return false;
    });
    
//-------------------------------------------------//    
// ��������� ��������� ���������
//-------------------------------------------------//
   	$('.parent').change(function() {
		
		$(this).nextAll('.parent2, label').remove();
		
		$('#show_sub_categories').append('<img src="/admin/img/loader.gif" style="float:center; margin-top:7px;" id="loader" alt="" />');
		
		$.post("/admin/ajax/get_child_categories.php", { parent_id: $(this).val() }, function(response){
			
			setTimeout("finishAjax('show_sub_categories', '"+escape(response)+"')", 400);
		});
		
		return false;
	});
    
//-------------------------------------------------//    
// ���������� �����
//-------------------------------------------------//
    $('#tags_form').submit(function() { 
        $(this).ajaxSubmit({
            target: "#output",
            beforeSubmit: function(){$("#wait").css("display", "block");  return true;},  
            success: function(){$("#wait").css("display", "none");  $('#tags').val("");}, 
            timeout: 3000    
        }); 
    return false;
    });
    
    
//-------------------------------------------------//   
// ����� ������ �� �����
//-------------------------------------------------//
    $('#search_name').keyup(function(event){
        if(event.keyCode != 40 && event.keyCode != 38)
        { 
            
            i = 0;
            $.ajax({
                    type: "POST",
                    url: "/admin/ajax/search_by_name.php",
                    data: { 
                        name : $(this).val(),
                        object : $(this).attr('data-value')
                    },
    				cache: false,
                    success: function(data){
                        $('#result').width($('#search_name').width() - 3).show().html(data);
                         $("select#res").attr("size",5); 
                    }  
            });
        }
    });
 
    
//-------------------------------------------------//
// �������� ���������� ������
//-------------------------------------------------//
     $('#search_name').focusout(function(){
        setTimeout(function(){   
            $('#result').hide();
        }, 200);
     })



//-------------------------------------------------//
// ��������� ���������� ������ ��� ����� ������
//-------------------------------------------------//
    $('.result_item').click(function(){
        $('div.result_item').removeClass('select');
        $(this).addClass("select");
        i = $(this).attr('id');
    });

//-------------------------------------------------//
// �������� ��� ��������
//-------------------------------------------------//
	$("#check_all").click(function() { 
        if( $(this).attr('checked'))
            $('input[type="checkbox"][name*="check"]').attr('checked', 'checked').parent().parent().parent().addClass('tr_select');
        else 
            $('input[type="checkbox"][name*="check"]').removeAttr('checked').parent().parent().parent().removeClass('tr_select');
	});
    
//-------------------------------------------------//
// ��������� ��������
//-------------------------------------------------//
    $('input[type="checkbox"]').click(function(){
        if($(this).prop("checked")) 
            $(this).parent().parent().parent().addClass('tr_select');
        else 
            $(this).parent().parent().parent().removeClass('tr_select');
    });

//-------------------------------------------------//
// ���������� ���� ��� �������� ����� ���������
//-------------------------------------------------//
    $('#event_apply').click(function(){
        
        if($('select[name="event"]').val() == '') 
        {
            alert("�������� ��������!");
            return false;
        } 
        if($('select[name="event"]').val() == 'delete')
        {
            if(confirm("�������, ��� ������ �������?"))
                $('#view_form').submit();
        }
        else 
            $('#view_form').submit(); 
        return false;     
    });   
    

//-------------------------------------------------//
// ���������� ���� ���������� ������
//-------------------------------------------------//        
    if(document.location == 'http://legal/admin/files/')
    {
        $('a.new').click(function(){
            var popup = $('#file_popup'); 
            $('#fade').css({'filter' : 'alpha(opacity=60)'}).fadeIn(100); 
            popup.fadeIn(100).css({'margin-top' : -popup.height()/2+'px', 'margin-left' : -popup.width()/2+'px'});
            return false;
        }); 
    }

//-------------------------------------------------//
// �������� ���� ���������� ������
//-------------------------------------------------// 
    $('#fade, .btn_close').click(function(){ 
       $('#fade, #file_popup').fadeOut(100);
    });
    
//-------------------------------------------------//
// ����������� ������ "�������� �� �����" ��� ���������� ���������
//-------------------------------------------------//     
    $('#viewOnSite').click(function(){
        
        if($(this).attr('href') == '#')
        {
            alert("�������� ����������! \n�������� ��� �� ��������.");
            return false;
        }  
    });
     
    
});//**********************************************//
//============== docunent ready end ===============//
//*************************************************//




//-------------------------------------------------//    
// ������� �������� �����
//-------------------------------------------------//
function del_tag(tag)
{
	    $("#wait").css("display", "block");
        var item = $(tag).parent().parent();
			$.ajax({
				type: "POST",
				url: "/admin/ajax/tags_del.php",
				data: {
				    delId : $(tag).attr("delId"),
                    articId : $(tag).attr("articId")
                    },
				cache: false,
				success: function(){
					item.slideUp('slow', function() {$(tag).remove();});
					$("#wait").css("display", "none");
				}
			});
}
//-------------------------------------------------//
// ������� ���������� ��� ������������  
//-------------------------------------------------//
function finishAjax(id, response){
  $('#loader').remove();
  $('#'+id).append(unescape(response));
} 


//-------------------------------------------------//
// ������� ������ ���������� ������  
//-------------------------------------------------//   
function select_name(div)
{ 
    $('#search_name').val($(div).text());
    $(div).parent().hide();
    document.location = document.location+'edit/'+$(div).attr('data-value')+'/';
}


//-------------------------------------------------//
// ������� ��������� ����������� ������ �����������
//-------------------------------------------------//
i = 0;

function keyPressed(e)
{
  var k = e.keyCode;
  var item = $('.result_item');
  var n = item.size();
  
        if(k == 38)//up
        {
            if(i >= 0)
            {
                if(i == 0) i = 1;
                if(i == 1) i = n; else i--;
                item.removeClass('select');
                $('.result_item#'+i).addClass("select");
            }
        }
        if(k == 40)//down
        {
            if(i <= n)
            {
                if(i == n )i = 0;
                i++;
                item.removeClass('select');
                $('.result_item#'+i).addClass("select");              
            }
        }
        if(k == 13)//enter
        {
            document.location = document.location+'edit/'+$('#result .select').attr('data-value')+'/';
        }
}