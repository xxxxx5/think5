 //删除角色
var delRole = function(rid , page){
  $.ajax({type:"post",
    url:"/admin/Access/delRole",
    dataType:'text',
    async:true, 
    data:{
        "rid":rid,
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
      url:'/admin/access/roleList',
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
          str+='<tr><td><input type="checkbox" name="ids[]" value="'+data[i].rid+'" lay-skin="primary"/></td>';
          str+='<td name="role_name">'+data[i].role_name+'</td>';
              
          str+='<td name="role_info">'+data[i].role_info+'</td>';
          str+='<td>'+getLocalTime(data[i].create_time)+'</td>';
          str+='<td><div class="layui-btn-group"><a onclick="editor('+i+',\''+data[i].role_name+'\',\''+data[i].role_info+'\',\''+data[i].rid+'\')" title="编辑角色" class="layui-btn layui-btn-primary layui-btn-small editor" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="layui-icon">&#xe642;</i></a>';
          str+='<a title="删除角色" class="layui-btn layui-btn-primary layui-btn-small j-tr-del" href="javascript:delRole('+data[i].rid+','+page+')" value="'+data[i].rid+'" page="'+page+'"><i class="layui-icon">&#xe640;</i></a></div></td></tr>'
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
//编辑角色按钮
var editor = function(key,role,info,rid){
 $.ajax({type:"post",
      url:"/admin/Access/getRoleAccess",
      dataType:'json',
      async:true, 
      data:{
          "role_id":rid,
      },"success":function(msg)
      {  
        $('#role_name').attr('placeholder',msg[1][0].role_name);
         $('#info').attr('placeholder',msg[1][0].role_info);

         for(var i=0;i<msg[0].length;i++){
            $('#acc input[value='+msg[0][i].access_id+']').prop('checked',true);
         }
      }
  });
  $('#sub').attr('onclick','editor_role('+rid+','+key+')');

}

//编辑角色
var editor_role = function(rid,key){
  var role_name = $('#role_name').val();
  var role_info = $('#info').val();
  var aid=[];
  $('input[name=aid]:checked').each(function(){
      aid.push($(this).val());
  });

  aid = aid.join(',');
  $.ajax({
    type:'post',
    url:"/admin/Access/editorRole",
    dataType:'json',
    async:true, 
    data:{
        "role_name":role_name,
        'role_info':role_info,
        'rid':rid,
        'aid':aid
    },"success":function(msg)
    {   
        var notice="设置成功";
        layui.use('layer', function(){
          var layer = layui.layer;
          layer.open({
                title: '提示信息', 
                type:0,
                content: notice,
                end:function(){
                  if(role_name.length>0){
                       $('.role_name').eq(key).html(role_name);
                   }
                   if(role_info.length>0){
                       $('.role_name').eq(key).html(role_info);
                   }
                }
            });  
        });  
    }
  });
  clearCss();
}
//创建角色
var sub = function(){
  var role_name = $('#role_name').val();
  var role_info = $('#info').val(); 
  var aid=[];
  $('input[name=aid]:checked').each(function(){
      aid.push($(this).val());
  })
  aid = aid.join(',');
  if(role_name.length==0){
       $('#sub').removeAttr("data-dismiss");
        $('#notice4').css('display','block');
      return;
  }
  if(role_info.length==0){
       $('#sub').removeAttr("data-dismiss");
        $('#notice2').css('display','block');
      return;
  }
   $('#sub').attr("data-dismiss",'modal');
  $.ajax({type:"post",
      url:"/admin/Access/addrole",
      dataType:'text',
      async:true, 
      data:{
          "role_name":role_name,
          'role_info':role_info,
          'aid':aid
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
                    window.location='/admin/Access/role';
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
                // window.location='http://www.baidu.com'; 
      }
  });
 clearCss();
}

//清除样式
function clearCss()
{
   $('#role_name').val('');
    $('#url').val('');
    $('#info').val('');
    $('#role_name').attr('placeholder','');
    $('#url').attr('placeholder','');
    $('#info').attr('placeholder','');
    $('#notice3').css('display','none');
   $('#notice2').css('display','none');
    $('#notice4').css('display','none');
     $('#notice').css('display','none');
      $('#sub').attr('onclick','sub()');
     $('input[name=aid]:checked').each(function(){
        $(this).removeAttr('checked');
     })
}
  //点击取消消除错误信息
  var reset = function(){
 
         clearCss();
  };
       
$(function(){

    // 判断角色名是否存在
        $('#role_name').blur(function(){
            var role_name = $('#role_name').val();
             $.ajax({type:"post",
                url:"/admin/Access/checkRole",
                dataType:'text',
                async:true, 
                data:{
                    "role_name":role_name,
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