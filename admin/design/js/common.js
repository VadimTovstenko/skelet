var mainClass = function(){

    this.init = function(){

    }

}







$(document).ready(function(){

    main = new mainClass();

    main.init();

    $.ajaxSetup({ cache: false });

    $(window).resize();

//-------------------------------------------------//    
// анимация при входе в админку
//-------------------------------------------------//
    $(".input_form, #mainMenu").animate({opacity: '1'}, 600,
        function(){
        $(".statistic").animate({opacity: '1', marginTop:'50'}, 600);
    });
    
//-------------------------------------------------//    
// Выделение активного меню
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
// Кнопка "Сохранить"
//-------------------------------------------------//
    $('a#save').click(function(){
        $('#add_edit_form').submit(); 
        return false;
    });



//-------------------------------------------------//
// Выделить все чекбоксы
//-------------------------------------------------//
	$("#check_all").click(function() {
        if( $(this).prop('checked'))
            $('input[type="checkbox"][name*="check"]').prop('checked', true).parent().parent().parent().addClass('tr_select');
        else 
            $('input[type="checkbox"][name*="check"]').prop('checked', false).parent().parent().parent().removeClass('tr_select');
	});
    
//-------------------------------------------------//
// Подсветка чекбокса
//-------------------------------------------------//
    $('input[type="checkbox"]').not(("#check_all")).click(function(){
        if($(this).prop("checked")) 
            $(this).parent().parent().parent().addClass('tr_select');
        else 
            $(this).parent().parent().parent().removeClass('tr_select');
    });

//-------------------------------------------------//
// Диалоговое окно при удалении групы элементов
//-------------------------------------------------//
    $('#event_apply').click(function(){
        
        if($('select[name="event"]').val() == '') 
        {
            alert("Выберите действие!");
            return false;
        } 
        if($('select[name="event"]').val() == 'delete')
        {
            if(confirm("Уверены, что хотите удалить?"))
                $('#view_form').submit();
        }
        else 
            $('#view_form').submit(); 
        return false;     
    });   
    

     
    
});
//*************************************************//
//============== docunent ready end ============//
//*************************************************//
