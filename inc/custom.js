$(document).ready(function(){
    //add user account
    $('#add_user_account').on('submit', function(){
        $("#add_user").text('Loading..');
        var data = new FormData(this);
            data.append('action','add_user_account');

            $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
              success: function(response){

                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#add_user").text('Submit');
              
              },
              error: function(){
                
                $(".modal").modal("hide");
                $("#alertbox_msg").html(response.message);
                $("#alertbox").modal();
                
              }   
        });
        return false;
    
    });

});









$(document).ready(function(){
	/* Start Delete Qoutation*/
    $('.del-quo-btn').click(function(){
		var id= $(this).data('id');
        var data = new FormData();
            data.append('id',id);
            data.append('action','delete_quotation');
            
            $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
                success: function(response){
                    if(response.status == 'success'){
                        alert(0);
                        
                        $(".modal").modal("hide");
                        $("#alertbox_msg").html(response.message);
                        $("#alertbox").modal();

                        $("#row"+id).fadeOut("slow");
                         setTimeout(function(){
                            $("#row"+id).remove();
                         }, 3000);
                    }
                },
                error:function(){
                    alert("Delete Failed");
                }
            });
            return false;
    });
	/* End Delete Qoutation*/

});



