$(function(){
    var isAfterStartDate = function(startDateStr, endDateStr) {
        var inDate = new Date(startDateStr),
            eDate = new Date(endDateStr);

        if(inDate < eDate) {
            return true;
        }

    };
    jQuery.validator.addMethod("isAfterStartDate", function(value, element) {

        return isAfterStartDate($('#start_date').val(), value);
    }, "End date should be after start date");

    var statusCheck = function(status) {
        if(status != 1) {
            return true;
        }

    };
    jQuery.validator.addMethod("statusCheck", function(value, element) {

        return statusCheck($('#status').val(), value);
    }, "Please approve or disapprove the leave ");

    var isAfterToday = function(startDateStr){
        var today = new Date();
            start = new Date(startDateStr);

            if(today < start){
                return true;
            }
    };

    jQuery.validator.addMethod("isAfterToday",function(value,element){
        return isAfterToday($('#start_date').val(),value);
    },"Start date should be after today");

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
            surname:"<p style = 'color:red'>surname should have three or more characters</p>",
            pwd:"<p style = 'color:red'>password should have six or more characters</p>",
            otherNames:"<p style = 'color:red'>Other names should have three or more characters</p>"
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
            surname:"<p style = 'color:red'>surname should have three or more characters</p>",
            pwd:"<p style = 'color:red'>password should have six or more characters</p>",
            otherNames:"<p style = 'color:red'>Other names should have three or more characters</p>"
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
            },
            status:{
                statusCheck:true
            }
        },
        errorClass: "invalid",
        messages:{
            remark:"<p style = 'color:red'>Remark should have more than ten  but less than twenty characters</p>",
            status:"<p style = 'color:red'>Please approve or disapprove the leave</p>"
        },

        submitHandler:function(form){
            form.submit();
        }

    }),
    $("form[name='leave_create']").validate({
        rules:{
            
           start:{
               required:true,
               isAfterToday:true
           },
           end:{
               required:true,
               isAfterStartDate: true
           },
           reason:{
               required:true,
               minlength:10
           }
        },
        errorClass: "invalid",
        messages:{
            reason:"<p style = 'color:red'>Please enter a reason  worthy of 10 or more characters</p>",
            end:"<p style = 'color:red'> End date should be after start date</p>",
            start:"<p style = 'color:red'>Start date should be after today</p>"
        },

        submitHandler:function(form){
            form.submit();
        }

    }),
    $("form[name='login']").validate({
        rules:{
            id:{
                required:true
            },
            pwd:{
                required:true
            },
        },
        errorClass:"invalid",
            messages:{
                id:"<p style='color:red'>Id is required</p>",
                pwd:"<p style='color:red'>Password is required</p>"
            },
            submitHandler:function(form){
                form.submit();
            }
    })

})