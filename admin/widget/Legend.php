<?
class Admin_Widget_Legend
{
    public static  function get($text, $name, $id, $link){
        return "<div class='legend'><div style='float: left;'>".$text.": <span>".$name."</span></div><div class='mini_tool'><img src='/admin/design/img/back.png' height='22' onclick='history.back()' title='�����'><a id='save' href='#'><img src='/admin/design/img/save.png' height='22' title='���������'></a><a href='$link' id='viewOnSite' target='_blank'><img src='/admin/design/img/view.png' height='22' title='�������� �� �����'></a><a href='#?w=400' rel='popup_name' id='$id' title='$name' class='delete'><img src='/admin/design/img/del.png' height='22' title='�������'></a></div></div>";
    }
}