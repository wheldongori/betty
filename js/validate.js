$(function(){
    $("form[name='employee_add']").validate({
        rules:{
            surname:{
                minlength:3,
            },
            pwd:{
                minlength:6,
                required:true,
            },
            otherNames:{
                minlength:3,
            }
        },
        errorClass: "invalid",

        messages:{
            surname:"surname should have three or more characters",
            pwd:"password should have six or more characters",
            otherNames:"Other names should have three or more characters"
        },

        submitHandler:function(form){
            form.submit();
        }
    //     // Called when the element is invalid:
    //     highlight: function(element) {
    //         $(element).css('background', '#ffdddd');
    //     },
    
    // // Called when the element is valid:
    //     unhighlight: function(element) {
    //         $(element).css('background', '#ffffff');
    //     }

    }),
    $("form[name='employee_edit']").validate({
        rules:{
            surname:{
                minlength:3,
            },
            pwd:{
                minlength:6,
                required:true,
            },
            otherNames:{
                minlength:3,
            }
        },
        errorClass: "invalid",
        messages:{
            surname:"surname should have three or more characters",
            pwd:"password should have six or more characters",
            otherNames:"Other names should have three or more characters"
        },

        submitHandler:function(form){
            form.submit();
        }

    }),
    $("form[name='leave_edit']").validate({
        rules:{
            
            remark:{
                minlength:10,
                required:true,
                maxlength:20
            }
        },
        errorClass: "invalid",
        messages:{
            remark:"Remark should have more than ten  but less than twenty characters"
        },

        submitHandler:function(form){
            form.submit();
        }

    }),
    $("form[name='leave_create']").validate({
        rules:{
            
           start:{
               required:true
           },
           end:{
               required:true
           },
           reason:{
               required:true,
               minlength:10
           }
        },
        errorClass: "invalid",
        messages:{
            reason:"Please enter a reason  worthy of 10 or more characters"
        },

        submitHandler:function(form){
            form.submit();
        }

    })

})