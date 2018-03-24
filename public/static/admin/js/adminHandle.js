 //删除管理员
var delAdmin = function(id , page){
  $.ajax({type:"post",
    url:"/admin/Access/delAdmin",
    dataType:'text',
    async:true, 
    data:{
        "id":id,
    },"success":function(msg)
    { 
      layui.use('layer', function(){
        var layer = layui.layer;
        if(msg==1){
          var notice='删除成功';
          layer.open({
              title: '提示信息', 
              type:0,
              content: notice,
               end:function(){
                  AjaxPage(page);
              }
        });  
        }else{
          var notice = "删除失败";
          layer.open({
              title: '提示信息', 
              type:0,
              content: notice,
          });  
        }
      });
    }
  });
}
//分页
var AjaxPage = function(page){
  $.ajax({
      url:'/admin/access/adminList',
      type:'post',
      dataType:'json',
      data: {apage:page},
      success:function(data){
          //console.log(data)
        var json = eval('('+data+')');
        var list = json.list;
        var data = list.data;
        var str='';
        for(var i=0;i<data.length;i++){
          str+='<tr><td><input type="checkbox" name="ids[]" value="'+data[i].id+'" lay-skin="primary"/></td>';
          str+='<td name="admin_name">'+data[i].admin_name+'</td>';
          str+='<td>'+getLocalTime(data[i].create_time)+'</td>';
          str+='<td><div class="layui-btn-group"><a onclick="editor('+i+',\''+data[i].admin_name+'\',\''+data[i].id+'\')" title="编辑角色" class="layui-btn layui-btn-primary layui-btn-small editor" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="layui-icon">&#xe642;</i></a>';
          str+='<a title="删除角色" class="layui-btn layui-btn-primary layui-btn-small j-tr-del" href="javascript:delAdmin('+data[i].id+','+page+')" value="'+data[i].id+'" page="'+page+'"><i class="layui-icon">&#xe640;</i></a></div></td></tr>'
        }
        $('#result').html(str);
        $('#pagelist').html(json.page);
      }
  });
}
//时间转换函数
function getLocalTime(nS) {
return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
} 
//编辑管理员按钮
var editor = function(key,admin,id){
 $.ajax({type:"post",
      url:"/admin/Access/getAdminAccess",
      dataType:'json',
      async:true, 
      data:{
          "admin_id":id,
      },"success":function(msg)
      {  
        $('#admin_name').attr('placeholder',msg[1][0].admin_name);
        $('#info').attr('placeholder','如不需修改则不填');
         $('#reinfo').attr('placeholder','如不需修改则不填');

         for(var i=0;i<msg[0].length;i++){
            $('#acc input[value='+msg[0][i].role_id+']').prop('checked',true);
         }
      }
  });
  $('#sub').attr('onclick','editor_admin('+id+','+key+')');

}

//编辑管理员
var editor_admin = function(id,key){
  var admin_name = $('#admin_name').val();
  var role_info = $('#info').val();
  var role_info2 = $('#reinfo').val();
  if(role_info2!=role_info){
    $('#sub').removeAttr("data-dismiss");
     $('#notice5').css('display','block');
     $('#notice6').css('display','block');
      return;
  }
  var rid=[];
  $('input[name=rid]:checked').each(function(){
      rid.push($(this).val());
  });                                                                                                                                
  rid = rid.join(',');
  // alert(rid);
  $.ajax({
    type:'post',
    url:"/admin/Access/editorAdmin",
    dataType:'json',
    async:true, 
    data:{
        "admin_name":admin_name,
        'role_info':role_info,
        'id':id,
        'rid':rid
    },"success":function(msg)
    {   
      // alert(msg);
        var notice='设置成功';
        layui.use('layer', function(){
          var layer = layui.layer;
          layer.open({
                title: '提示信息', 
                type:0,
                content: notice,
                end:function(){
                  if(admin_name.length>0){
                       $('.admin_name').eq(key).html(admin_name);
                   }
                }
            });  
        });  
    }
  });
  clearCss();
}
//创建管理员
var sub = function(){
  var admin_name = $('#admin_name').val();
  var role_info = $('#info').val(); 
  var role_info2 = $('#reinfo').val();
  var rid=[];
  $('input[name=rid]:checked').each(function(){
      rid.push($(this).val());
  })

  rid = rid.join(',');
  if(admin_name.length==0){
       $('#sub').removeAttr("data-dismiss");
        $('#notice4').css('display','block');
      return;
  }
  if(role_info.length==0){ 
       $('#sub').removeAttr("data-dismiss");
        $('#notice2').css('display','block');
      return;
  }
  if(role_info2!=role_info){
    $('#sub').removeAttr("data-dismiss");
     $('#notice5').css('display','block');
     $('#notice6').css('display','block');
      return;
  }
   $('#sub').attr("data-dismiss",'modal');
  $.ajax({type:"post",
      url:"/admin/Access/addadmin",
      dataType:'text',
      async:true, 
      data:{
          "admin_name":admin_name,
          'role_info':role_info,
          'rid':rid
      },"success":function(msg)
      { 
          
          layui.use('layer', function(){
            var layer = layui.layer;
            if(msg==1){
              var notice='设置成功';
              layer.open({
                  title: '提示信息', 
                  type:0,
                  content: notice,
                  end:function(){
                    window.location='/admin/Access/admin';
                  }
              });  

            }else{
              var notice='设置失败';
              layer.open({
                  title: '提示信息', 
                  type:0,
                  content: notice,
              });  
            } 
          });                
      }
  });
 clearCss();
}

//清除样式
function clearCss()
{
   $('#admin_name').val('');
    $('#info').val('');
    $('#reinfo').val('');
    $('#admin_name').attr('placeholder','');
    $('#info').attr('placeholder','');
    $('#reinfo').attr('placeholder','');
    $('#notice3').css('display','none');
   $('#notice2').css('display','none');
    $('#notice4').css('display','none');
     $('#notice5').css('display','none');
      $('#notice6').css('display','none');
     $('#notice').css('display','none');
      $('#sub').attr('onclick','sub()');
     $('input[name=rid]:checked').each(function(){
        $(this).removeAttr('checked');
     })
}
  //点击取消消除错误信息
  var reset = function(){
 
         clearCss();
  };
       
$(function(){

    // 判断管理员名是否存在
        $('#admin_name').blur(function(){
            var admin_name = $('#admin_name').val();
             $.ajax({type:"post",
                url:"/admin/Access/checkAdmin",
                dataType:'text',
                async:true, 
                data:{
                    "admin_name":admin_name,
                },"success":function(msg)
                { 
                    if(msg==-1){
                        $('#notice').css('display','block');
                        $('#sub').attr('disabled',"true");
                    }else{
                        $('#notice').css('display','none');
                        $('#sub').removeAttr("disabled");
                    }
                }
            });
        });
})