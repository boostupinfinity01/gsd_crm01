/* User Add*/
$(document).ready(function(){
    /* logout account */
    $(".logout_btn").on('click',function(){
        
        var data = new FormData();
        data.append("action","logout_account");
        $.ajax({url: "ajax.php", type: "post", data:data, cache:false, processData:false, contentType:false, dataType:"json",
            success: function(response)
            {
                if(response.status == "success")
                {
                    swal( "", response.message, "success");
                    // $(".modal").modal("hide");
                    // $("#alertbox_msg").html(response.message);
                    // $("#alertbox").modal();
                    location.replace("pages-login.php");
                }
                else
                {
                  swal( "", 'Failed to logout your account', "success");
                    // $(".modal").modal("hide");
                    // $("#alertbox_msg").html("<div class='alert alert-success' style='padding:10px;'>Failed to logout your account.</div>");
                    // $("#alertbox").modal();
                }
            },
            error: function()
            {
                swal( "", "Some error occurred", "success");

                // $(".modal").modal("hide");
                // $("#alertbox_msg").html("<div class='alert alert-success' style='padding:10px;'>Some error occurred.</div>");
                // $("#alertbox").modal();
            }
        });
        return false;
    });
    
    //add user account
    $('#add_user_account').on('submit', function(){
        $("#add_user").text('Loading..');
        var data = new FormData(this);
            data.append('action','add_user_account');

            $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
              success: function(response){
                    // $(".modal").modal("hide");
                    // $("#alertbox_msg").html(response.message);
                    // $("#alertbox").modal();
                    $("#add_user").text('Submit');

                if(response.status == 'success'){
                 swal( "", response.message, "success");
                    // $(".modal").modal("hide");
                    // $("#alertbox_msg").html(response.message);
                    // $("#alertbox").modal();
                    
                    
                }else if(response.status == 'failed'){
                  swal( "", response.message,"error");
                }
              },
              error: function(){
                //$(".modal").modal("hide");
                    swal("", response.message, "error");
                    // $("#alertbox_msg").html(response.message);
                    // $("#alertbox").modal();
              }   
        });
        return false;
    });
});

/* User Edit */
$(document).ready(function(){
    //edit user account
    $('#edit_user_account').on('submit', function(){
        var user_eid= $(this).data('id');
        $("#edit_user").text('Loading..');
        var data = new FormData(this);
            data.append("id",user_eid);
            data.append('action','edit_user_account');
            
            $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
              success: function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                //if(response.status == 'success'){
                    //$(".modal").modal("hide");
                    //$("#alertbox_msg").html(response.message);
                    //$("#alertbox").modal();
                    
                    //$("#add_user").text('Submit');
                //}
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
	/* Start Delete users*/
    $('.delete_user_btn').click(function(){
		var id= $(this).data('id');
        var data = new FormData();
            data.append('id',id);
            data.append('action','delete_user');
            
            $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
                success: function(response){
                    if(response.status == 'success'){
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
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    //alert("Delete Failed");
                }
            });
            return false;
    });
	/* End Delete users*/
});

$(document).ready(function(){

    // Add Reception Form //
    $('#form_reception').on('submit', function(){
        $("#recep_btn").text('Loading..');
        var data = new FormData(this);
            data.append('action','add_form_reception');

            $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
              success: function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                if(response.status == 'success'){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    
                    $("#recep_btn").text('Submit');
                    $(this).load(function(){
                        
                 });
                }
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


/* Edit Visitor Form Function*/
$(document).ready(function(){
   $("#edit_form_reception").on('submit', function(){
           var recp_id = $(this).data("id");
           $("#recep_edit_btn").text('Loading..');
           var data = new FormData(this);
           data.append("id",recp_id);
           data.append('action','edit_reception_form');
           $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
                success:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#recep_edit_btn").text('Update');
                },
                error:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                }
            });
            return false;
       });
});

/* Delete Visitor Form Function*/
$(document).on('click','#recepf_del_btn',function(){
    $(this).text('Loading..');
    var id = $(this).data('id');
    var data = new FormData();
    data.append("id",id);
    data.append('action',"rec_del_form");
        
    $.ajax({url: "ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType: "json",
        success: function(response){
            $(".modal").modal("hide");
            $("#alertbox_msg").html(response.message);
            $("#alertbox").modal();
            $(this).text('Deleted');
            setTimeout(function() {
             location.reload();
            }, 2000);
        },
        error: function(response){
            $(".modal").modal("hide");
            $("#alertbox_msg").html(response.message);
            $("#alertbox").modal();
        }
    }); 
     
});


/* User activate function */
$(document).on('click','.activeuser_btn',function(){
    var id = $(this).data('id');
    var data = new FormData();
    data.append('id',id);
    data.append('action','active_user');
    
    $.ajax({url:"ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
       success: function(response){
         $(".modal").modal("hide");
         $("#alertbox_msg").html(response.message);
         $("#alertbox").modal();
           setTimeout(function() {
             location.reload();
            }, 2000);
        },
       error: function(){
        $(".modal").modal("hide");
        $("#alertbox_msg").html(response.message);
        $("#alertbox").modal();
        }
    });
    return false;    
    
});

/* User deactivate function */
$(document).on('click','.deactiveuser_btn',function(){
        
    var id = $(this).data('id');
    var data = new FormData();
    data.append('id',id);
    data.append('action','deactive_user');
    
    $.ajax({url:"ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
       success: function(response){
         $(".modal").modal("hide");
         $("#alertbox_msg").html(response.message);
         $("#alertbox").modal();   
         setTimeout(function() {
             location.reload();
            }, 2000);     
        },
       error: function(){
        $(".modal").modal("hide");
        $("#alertbox_msg").html(response.message);
        $("#alertbox").modal();
        }
    });
    return false;    
    
});


/* ============================================================================== */

/* Add Visitor Visa Form */
$(document).ready(function(){
    //add user account
    $('#add_visitor_form').on('submit', function(){
        $("#add_user").text('Loading..');
        var data = new FormData(this);
            data.append('action','add_visitor_visa_form');
            
            $.ajax({url: "ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
              success: function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    /*if(response.status == 'success'){
                        $(".modal").modal("hide");
                        $("#alertbox_msg").html(response.message);
                        $("#alertbox").modal();
                        $("#add_user").text('Submit');
                    }*/
              },
              error: function(){
                alert('Not add visitor visa form successfully');
                    /*$(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();*/              
                    }   
        });
        return false;
    });
});

/* Edit Visitor Form Function*/
$(document).ready(function(){
   $("#edit_visitor_form").on('submit', function(){
           var vv_id = $(this).data("id");
           $("#visitor_edit_btn").text('Loading..');
           var data = new FormData(this);
           data.append("visitor_id",vv_id);
           data.append('action','edit_visitor_visa_form');
           $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
                success:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#visitor_edit_btn").text('Submit');
                },
                error:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                }
            });
            return false;
       });
});
    
    
/* visitor Delete/deactivate function */
$(document).on('click','#visitor_del_btn',function(){
    $("#visitor_del_btn").text('Loading..');
    
    var vv_id = $(this).data("id");
     
    var data = new FormData();
    data.append('visitor_id',vv_id);
    data.append('action','visitor_visa_del');
    
    $.ajax({url:"ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
       success: function(response){
         $(".modal").modal("hide");
         $("#alertbox_msg").html(response.message);
         $("#alertbox").modal();   
         setTimeout(function() {
             location.reload();
            }, 2000);
         
        },
       error: function(){
        $(".modal").modal("hide");
        $("#alertbox_msg").html(response.message);
        $("#alertbox").modal();
        }
    });
    return false;    
    
});



/* ============================================================================== */


/* Add Tourist Visa Form */
 $(document).ready(function(){
    
    //Add Tourist Form Requirement
    $('#add_tourist_form').on('submit', function(){
        $("#add_tourist").text('Loading..');
        
        var data = new FormData(this);
            data.append('action','add_tourist_visa_form');  
            
            $.ajax({url: "ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
              success: function(response){
                    //alert('Add Successfully');
                    //$(".modal").modal("hide");
                    //$("#alertbox_msg").html(response.message);
                    //$("#alertbox").modal();
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#add_user").text('Submit');
              },
              error: function(response){
                    alert('Not Add Successfully');
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();             
                    }   
        });
        return false;
    });
}); 

/* Edit Visitor Form Function*/
$(document).ready(function(){
   $("#edit_tourist_form").on('submit', function(){
           var t_id = $(this).data("id");
           $("#update_tourist_btn").text('Loading..');
           var data = new FormData(this);
           data.append("tourist_id",t_id);
           data.append('action','edit_tourist_visa_form');
           $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
                success:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#update_tourist_btn").text('Submit');
                },
                error:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                }
            });
            return false;
       });
});



/* ============================================================================== */

/* Add Study Visa Form */
$(document).ready(function(){
    //add user account
    $('#add_study_form').on('submit', function(){
        $("#study_form_btn").text('Loading..');
        var data = new FormData(this);
            data.append('action','add_study_visa_form');
            
            $.ajax({url: "ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
              success: function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    /*if(response.status == 'success'){
                        $(".modal").modal("hide");
                        $("#alertbox_msg").html(response.message);
                        $("#alertbox").modal();
                        $("#add_user").text('Submit');
                    }*/
              },
              error: function(){
                /*alert('Not add study visa form successfully');*/
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    }   
        });
        return false;
    });
});

/* Edit Study Visa Form Function*/
$(document).ready(function(){
   $("#edit_study_form").on('submit', function(){
           var s_id = $(this).data("id");
           $("#study_edit_btn").text('Loading..');
           var data = new FormData(this);
           data.append("study_id",s_id);
           data.append('action','edit_study_visa_form');
           $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
                success:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#visitor_edit_btn").text('Submit');
                },
                error:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                }
            });
            return false;
       });
});
    
    
/* Study Visa Delete/deactivate function */
$(document).on('click','#study_del_btn',function(){
    $("#study_del_btn").text('Loading..');
    
    var s_id = $(this).data("id");
     
    var data = new FormData();
    data.append('study_id',s_id);
    data.append('action','study_visa_del');
    
    $.ajax({url:"ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
       success: function(response){
         $(".modal").modal("hide");
         $("#alertbox_msg").html(response.message);
         $("#alertbox").modal();   
         setTimeout(function() {
             location.reload();
            }, 2000);
         
        },
       error: function(){
        $(".modal").modal("hide");
        $("#alertbox_msg").html(response.message);
        $("#alertbox").modal();
        }
    });
    return false;    
    
});



/* ============================================================================== */

/* Add Work Visa Form */
$(document).ready(function(){
    //add user account
    $('#add_work_form').on('submit', function(){
        $("#work_save_btn").text('Loading..');
        var data = new FormData(this);
            data.append('action','add_work_visa_form');
            
            $.ajax({url: "ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
              success: function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#add_user").text('Submit');
                    /*if(response.status == 'success'){
                        $(".modal").modal("hide");
                        $("#alertbox_msg").html(response.message);
                        $("#alertbox").modal();
                        $("#add_user").text('Submit');
                    }*/
              },
              error: function(){
                /*alert('Not add study visa form successfully');*/
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    }   
        });
        return false;
    });
});

/* Edit Work Visa Form Function*/
$(document).ready(function(){
   $("#edit_work_form").on('submit', function(){
           var s_id = $(this).data("id");
           $("#work_edit_btn").text('Loading..');
           var data = new FormData(this);
           data.append("work_id",s_id);
           data.append('action','edit_work_visa_form');
           $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
                success:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#visitor_edit_btn").text('Submit');
                },
                error:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                }
            });
            return false;
       });
});
    

/* Work Visa Delete/deactivate function */
$(document).on('click','#work_del_btn',function(){
    $("#work_del_btn").text('Loading..');
    
    var s_id = $(this).data("id");
     
    var data = new FormData();
    data.append('work_id',s_id);
    data.append('action','work_visa_del');
    
    $.ajax({url:"ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
       success: function(response){
         $(".modal").modal("hide");
         $("#alertbox_msg").html(response.message);
         $("#alertbox").modal();   
         setTimeout(function() {
             location.reload();
            }, 2000);
         
        },
       error: function(){
        $(".modal").modal("hide");
        $("#alertbox_msg").html(response.message);
        $("#alertbox").modal();
        }
    });
    return false;    
    
});



/* ============================================================================== */

/* Add Business Visa Form */
$(document).ready(function(){
    //add user account
    $('#add_business_form').on('submit', function(){
        $("#bus_save_btn").text('Loading..');
        var data = new FormData(this);
            data.append('action','add_bus_visa_form');
            
            $.ajax({url: "ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
              success: function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#add_user").text('Submit');
                    /*if(response.status == 'success'){
                        $(".modal").modal("hide");
                        $("#alertbox_msg").html(response.message);
                        $("#alertbox").modal();
                        $("#add_user").text('Submit');
                    }*/
              },
              error: function(){
                /*alert('Not add study visa form successfully');*/
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    }   
        });
        return false;
    });
});

/* Edit Business Visa Form Function*/
$(document).ready(function(){
   $("#edit_business_form").on('submit', function(){
           var bus_id = $(this).data("id");
           $("#bus_edit_btn").text('Loading..');
           var data = new FormData(this);
           data.append("business_id",bus_id);
           data.append('action','edit_bus_visa_form');
           $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
                success:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#visitor_edit_btn").text('Submit');
                },
                error:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                }
            });
            return false;
       });
});
    
/* Business Visa Delete/deactivate function */
$(document).on('click','#bus_del_btn',function(){
    $("#bus_del_btn").text('Loading..');
    
    var bus_id = $(this).data("id");
     
    var data = new FormData();
    data.append('business_id',bus_id);
    data.append('action','bus_visa_del');
    
    $.ajax({url:"ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
       success: function(response){
         $(".modal").modal("hide");
         $("#alertbox_msg").html(response.message);
         $("#alertbox").modal();   
         setTimeout(function() {
             location.reload();
            }, 2000);
         
        },
       error: function(){
        $(".modal").modal("hide");
        $("#alertbox_msg").html(response.message);
        $("#alertbox").modal();
        }
    });
    return false;    
    
});



/* ============================================================================== */

/* Add Family Visa Form */
$(document).ready(function(){
    //add user account
    $('#add_family_form').on('submit', function(){
        $("#family_save_btn").text('Loading..');
        var data = new FormData(this);
            data.append('action','add_family_visa_form');
            
            $.ajax({url: "ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
              success: function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#add_user").text('Submit');
                    /*if(response.status == 'success'){
                        $(".modal").modal("hide");
                        $("#alertbox_msg").html(response.message);
                        $("#alertbox").modal();
                        $("#add_user").text('Submit');
                    }*/
              },
              error: function(){
                /*alert('Not add study visa form successfully');*/
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    }   
        });
        return false;
    });
});

/* Edit Family Visa Form Function*/
$(document).ready(function(){
   $("#edit_family_form").on('submit', function(){
           var bus_id = $(this).data("id");
           $("#fmy_edit_btn").text('Loading..');
           var data = new FormData(this);
           data.append("family_id",bus_id);
           data.append('action','edit_family_visa_form');
           $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
                success:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#visitor_edit_btn").text('Submit');
                },
                error:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                }
            });
            return false;
       });
});
    
/* Family Visa Delete/deactivate function */
$(document).on('click','#family_del_btn',function(){
    $("#family_del_btn").text('Loading..');
    
    var fmy_id = $(this).data("id");
     
    var data = new FormData();
    data.append('family_id',fmy_id);
    data.append('action','family_visa_del');
    
    $.ajax({url:"ajax.php", type:"POST", data:data, cache:false, contentType:false, processData:false, dataType:"json",
       success: function(response){
         $(".modal").modal("hide");
         $("#alertbox_msg").html(response.message);
         $("#alertbox").modal();   
         setTimeout(function() {
             location.reload();
            }, 2000);
         
        },
       error: function(){
        $(".modal").modal("hide");
        $("#alertbox_msg").html(response.message);
        $("#alertbox").modal();
        }
    });
    return false;    
    
});



$(document).ready(function(){

    // Add PTE Form //
    $('#add_pte_form').on('submit', function(){
        $("#pte_save_btn").text('Loading..');
        var data = new FormData(this);
            data.append('action','add_form_pte');

            $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
              success: function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                if(response.status == 'success'){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    
                    $("#recep_btn").text('Submit');
                    $(this).load(function(){
                        
                 });
                }
              },
              error: function(){
                $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
              }   
        });
        return false;
    
    });

})


/* Edit PTE Form Function*/
$(document).ready(function(){
   $("#edit_pte_form").on('submit', function(){
           var pte_id = $(this).data("id");
           $("#pte_edit_btn").text('Loading..');
           var data = new FormData(this);
           data.append("id",pte_id);
           data.append('action','edit_pte_form');
           $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
                success:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    $("#visitor_edit_btn").text('Submit');
                },
                error:function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                }
            });
            return false;
       });
});



$(document).ready(function(){

    // Add IELTS Form //
    $('#add_ielts_form').on('submit', function(){
        $("#iel_save_btn").text('Loading..');
        var data = new FormData(this);
            data.append('action','add_form_pte');

            $.ajax({url: "ajax.php", type:"post", data:data, cache:false, contentType:false, processData:false, dataType:"json",
              success: function(response){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                if(response.status == 'success'){
                    $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
                    
                    $("#recep_btn").text('Submit');
                    $(this).load(function(){
                        
                 });
                }
              },
              error: function(){
                $(".modal").modal("hide");
                    $("#alertbox_msg").html(response.message);
                    $("#alertbox").modal();
              }   
        });
        return false;
    
    });

})