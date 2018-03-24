$(function(){

    // 判断权限名是否存在
        $('#access_name').blur(function(){
            var access_name = $('#access_name').val();
             $.ajax({type:"post",
                url:"/admin/Access/checkName",
                dataType:'text',
                async:true, 
                data:{
                    "access_name":access_name,
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
        $('.j-tr-del').click(function(){
              var aid = $(this).attr('value');
              $.ajax({type:"post",
                url:"/admin/Access/delAccess",
                dataType:'text',
                async:true, 
                data:{
                    "aid":aid,
                },"success":function(msg)
                { 
                        if(msg==1){
                            var notice='删除成功';

                        }else{
                            
                            
                            var notice = "删除失败";
                        }
                        layui.use('layer', function(){
                              var layer = layui.layer;
                              layer.open({
                                    title: '提示信息', 
                                    type:0,
                                    content: notice,
                                     end:function(){
                                        window.location.href="/admin/Access/access";
                                      }
                              });  

                        });
                    }
                });
          });

        //编辑权限
       // $('.editor_access').each(function(){
       //      $(this).click(function(){
       //          var aid = $(this).attr('value');
       //          var key = $(this).attr('key');
       //         $('#access_name').val($('.access_name').eq(key).html());
       //         $('#url').val($('.access_url').eq(key).html());
       //         $('#info').val($('.access_info').eq(key).html());
       //         if(parseInt($('.access_status').eq(key).html())==1){
       //              $("#kai").prop('checked','true');
       //              $("#guan").removeAttr('checked');
       //         }else{
       //              $("#guan").prop('checked','true');
       //              $("#kai").removeAttr('checked');
       //         }
       //     })
       // });

       $('#reset').click(function(){

         clearCss();
       });

        //提交权限信息
        $('#sub').click(function(){
            var access_name = $('#access_name').val();
            var access_url = $('#url').val();
            var access_info = $('#info').val(); 
            if(access_name.length==0){
                 $('#sub').removeAttr("data-dismiss");
                  $('#notice4').css('display','block');
                return;
            }
            if(access_info.length==0){
                 $('#sub').removeAttr("data-dismiss");
                  $('#notice2').css('display','block');
                return;
            }
            if(access_url.length==0){
                 $('#sub').removeAttr("data-dismiss");
                  $('#notice3').css('display','block');
                return;
            }
             $('#sub').attr("data-dismiss",'modal');
            $.ajax({type:"post",
                url:"/admin/Access/addaccess",
                dataType:'text',
                async:true, 
                data:{
                    "access_name":access_name,
                    'access_url':access_url,
                    'access_info':access_info,
                },"success":function(msg)
                { 
                    
                          
                    if(msg==1){
                        var notice='设置成功';
                        layui.use('layer', function(){
                        var layer = layui.layer;
                        layer.open({
                              title: '提示信息', 
                              type:0,
                              content: notice,
                              end:function(){
                                window.location.href="/admin/Access/Access";
                              }
                          });  

                          
                      });  

                    }else{
                        var notice='设置失败';
                    
                        layui.use('layer', function(){
                          var layer = layui.layer;
                          layer.open({
                                title: '提示信息', 
                                type:0,
                                content: notice,
                            });  

                            
                        }); 
                    } 
                          // window.location='http://www.baidu.com'; 
                }
            });
            clearCss();

        });
        function clearCss()
        {
           $('#access_name').val('');
            $('#url').val('');
            $('#info').val('');
             $('#notice3').css('display','none');
           $('#notice2').css('display','none');
            $('#notice4').css('display','none');
             $('#notice').css('display','none');
        }

})