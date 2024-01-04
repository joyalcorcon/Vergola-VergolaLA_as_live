$(document).ready(function(){  
    var qty = 0;
    var len = 0;
    var price = 0;
    var rrp = 0;
    var obj = null; 
    var width = 0;
    var vr_type = "";

    $("script[src='singlebay.js']").remove();
    $("script[src='doublebay.js']").remove();
    $("script[src='doublebay_vr2.js']").remove(); 

    $('.qtylen, .input-ft').attr('readonly', true);   

    vr_type = $("#framework").val();
    //$("td.td-len").css("visibility", "hidden"); 
    $("td.td-len").css("display", "none");
    $("input.num, input.input-size").attr("autocomplete", "off");

    $('input.num, input.qtylen, input.length, input.width, input.input-ft').bind('keypress',accept_number);
     
    // $("table.table-subtotal input").val("");
    $("table.table-subtotal input").not("#total_gst").val("");
    $(".table-subtotal-holder").show();

    $("#projectcomm").hide();
    $("#projectcost").hide();

    $(".table-subtotal input").each(function(){ 
        $(this).attr('readonly', true); 
    });
     
    var status = $("#status").val();

    if(status == ""){ //status is blank and view type is in creating quote
        isCreating = 1;
        viewType = "create";
    }else if(status.toLowerCase()=="quoted" || status.toLowerCase()=="in progress"){
        viewType = "edit";
        isCreating = 0;
    }else if(status.toLowerCase()=="won" || status.toLowerCase()=="lost"){
        viewType = "read only";
        isCreating = 0;
    }

    //$("tr.tr-vergola td.td-qty input").prop('readonly', true);
    //$("#IRV61_qty").prop('readonly', false);


    if(isCreating==1){

        //create view
        //$("#lengthid").val(""); //empty the input dimension field if showing of created quote.
        //$("#widthid").val(""); 
        //$("#dbwidthid1").val("");
        $("#length_ft").val("");
        $("#length_in").val("");
        $("#width_ft").val("");
        $("#width_in").val("");
 
        $(".td-qty").children("input:text").not( ".qtylen-disbursements" ).each(function(){
             
            //console.log(vr_type);
            if($(this).val().length<1 ){
                $(this).addClass("field-warning");
            }

            if($(this).val().length<1 && vr_type == "Single Bay VR0"){
                $(this).addClass("field-warning");
            }
             
        });

        //addClass( "field-warning" );
         
      
    }else{ 
        //edit view 
        // $('.length').each(function(){
        //THIS IS TESTING TRY TO COMMENT NEXT 2 lines (THIS IS GOOD and not needed anymore so it is good it is commented.)  
        //$("#template_table .length").val($('#lengthid').val());
        //$("#template_table .width").val($('#widthid').val());
        if($("#default_color").val()!=""){
            $("#template_table select[name='colour[]'] option[value='"+$("#default_color").val()+"']").attr("selected", true);
        }
    }

    if($(".show-form-disable").length>0 || viewType=="read only"){

        $("#project input, #output input,#output select, .table-subtotal-holder input, #downbtn input").each(function(){
            //if($(".show-form").length==0){
                $(this).attr('disabled', true);
            //}
        });     

        $("#cancel").attr('disabled', false);
    }


    if($("#frameworktype").length>0 && $("#frameworktype").children("option:selected").val()=="Drop-In"){
        //alert("here");
        $(".tbody_framework").remove();
    }
   
    // var sel_colour = $(".color_select").children("option:selected").val();  
    // $("select.colour").val(sel_colour); 
 
    
    $(".color_select").change(function() {  //alert($(this).val());
        $("select.colour").val($(this).val()); 
        $("#template_table select[name='colour[]'] option[value='"+$(this).val()+"']").attr("selected", true).prop('selected', true);
    });  
  
    $(".length, .width").each(function(e){
          
        id = $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");

    });

     
    $("#widthid").focus(function(){
        $("#output input,#output select").each(function(e){
            $(this).removeAttr('disabled');
        }); 
    });
 
    var length_total_inch = 0;
    var width_total_inch = 0;
     
     
    $("#length_ft, #length_in ,#width_ft,#width_in").change(function(){  // alert("here 1");

        if(selectedFramework=="Single Bay VR0" || selectedFramework=="Single Bay VR0 - Gutter"){
            //alert("trigger 1");
        }else if(Number($("#length_ft").val())>0 || Number($("#width_ft").val())>0 ){ 
            length_total_inch = Number($("#length_ft").val())*12 + Number($("#length_in").val());   
            width_total_inch = Number($("#width_ft").val())*12 + Number($("#width_in").val());  

            $("#lengthid").val(length_total_inch); 
            $("#widthid").val(width_total_inch);

        }else{ return; }

        $('.length').each(function(){ 
           $(this).val(length_total_inch);  
           $(this).parent().parent("tr").children("td.td-ft").children("input.input-ft").val(get_feet_value(length_total_inch));
        });


        $('.width').each(function(){ 
            if ($(this).attr("id") == 'louvres-len_ft') {
                if (width_total_inch != undefined) {
                    $(this).val(width_total_inch);
                }
                if (get_feet_value(width_total_inch) != undefined) {
                    $(this).parent().parent("tr").children("td.td-ft").children("input.input-ft").val(get_feet_value(width_total_inch));
                }
            } else {
                $(this).val(width_total_inch);
                $(this).parent().parent("tr").children("td.td-ft").children("input.input-ft").val(get_feet_value(width_total_inch));
            }
        });

         
        $("#output .rrp").each(function(e){ 
            //console.log($(this).parent().parent("tr").children("td.td-rrp").html());
            var len = 0;
            qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val(); 
             
            //len = $(this).parent().parent("tr").children("td.td-len").children("input:visible").val();
            len = Number($(this).parent().parent("tr").children("td.td-len").children("input.input-in[style!=display:none]").val());
            var obj = $(this).parent().parent("tr").children("td.td-item").children("select").length;
            if(obj>0){
                price = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price");
             }else{
                price = $(this).parent().parent("tr").children("td.td-item").children("input.price").val();
             }

            var finishColor = $(this).parent().parent("tr").children("td.td-finish-color").children("select").length;
            var finishRrp = 0;
            if(finishColor>0){ 
                finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
                //console.log("finishrrp: "+finishRrp);
             } 

            var webbing = $(this).parent().parent("tr").children("td.td-webbing").children("select").length;
            var webbingRrp = 0;
            if(webbing>0){ 
                if($(this).parent().parent("tr").children("td.td-webbing").children("select").children("option:selected").val()=="Yes"){
                    webbingRrp = Number($(this).parent().parent("tr").children("td.td-webbing").children("select").attr("webrrp")); 
                }
            }
            //console.log(price);
            if(typeof(len) == 'undefined' || len==0 || isNaN(len)){
                len = 1; 
            }
             
            rrp = qty*len*price;
            rrp = rrp + (finishRrp * len * qty);
             
            $(this).val(rrp.toFixed(2));

            id = $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");

            //if(id=="IRV67"){alert(price);
             //     console.log("price: "+price);
                // console.log("width: "+width);
                // console.log("len: "+len);
                // console.log("qty: "+qty);
                // console.log("rrp: "+rrp); 
            // }

            var category = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("category");
            id = $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");
            
            if(category == "Louvers"){ //|| id == "IRV31"
                //alert("HERE id:"+id);
                //set the number and cost for the louver
                //len = Number($("#lengthid").val()); 
                //width = Number($("#widthid").val()); 
                len = length_total_inch; //39.37 In = 1 meter
                width = width_total_inch;
                
                //qty = Math.floor(5*(len/39.37));//Number($("#louvres-qty").val());
                qty = Math.ceil(len/7.874);
             
                //console.log("louvres-qty: "+ qty);
                //var f_qty = Math.floor(qty*len);
                //console.log("Floor louvres-qty: "+qty);
                
                $("#louvres-qty").val(qty); 
                price = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price");
                finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

                rrp = qty*price*width;
                rrp = rrp + (finishRrp * width * qty); 

                // console.log("finishRrp: "+finishRrp);
                // console.log("width: "+width);
                // console.log("len: "+len);
                // console.log("qty: "+qty);
                // console.log("rrp: "+rrp);
                //alert("0:"+$(this).val());
                $(this).val(rrp.toFixed(2));
                //alert("1:"+$(this).val());

                //COMPUTE ENDCAP qty and cost.
                qty = qty*2; 
                //console.log(qty);
                $("#endcap-qty").val(qty.toFixed(0)); 
                   
                price = $("#endcap-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
                finishRrp = Number($("#endcap-qty").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

                rrp = qty*price;
                rrp = rrp + finishRrp; 
                // console.log("qty: "+qty);
                // console.log("price: "+price);
                // console.log("rrp: "+rrp);
                $("#endcap-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
                //alert("endcap-qty rrp: "+$("#endcap-qty").parent().parent("tr").children("td.td-rrp").children("input").val());

                //COMPUTE PIVOT STRIP qty and cost.
                //len = Number($("#lengthid").val());
                qty = Math.ceil(((len/39.37)*5*2)/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
                //console.log("PIVOT QTY: "+qty);
                $("#pivot-qty").val(qty);
                   
                price = $("#pivot-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
                finishRrp = Number($("#pivot-qty").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

                var rrp = (qty*price)+finishRrp;
                $("#pivot-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
 
                //COMPUTE LINK BAR. 
                //len = Number($("#lengthid").val()); 
                //qty = Math.round((len*5*2)/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
                qty = $("#louvres-qty").val(); 
                qty = Math.ceil(qty/12); 
                //console.log("PIVOT QTY: "+qty); 
                $("#linkBar-qty").val(qty); 
                
                price = $("#linkBar-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
                finishRrp = Number($("#linkBar-qty").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

                var rrp = (qty*price)+finishRrp;
                $("#linkBar-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
  
            } 


            if(id == "IRV31"  ){ 
                var len = 0;

                $("#output .td-ft .gutter-length").each(function(e){
                    //console.log("gutter-length: "+get_feet_to_inch($(this).val())); 
                    if($(this).parent().parent("tr").children("td.td-qty").children("input").val()>0 && $(this).val().length>0){  
                        len = Number(len) + (Number($(this).parent().parent("tr").children("td.td-qty").children("input").val()) * Number(get_feet_to_inch($(this).val())));
                    }
                });

                //console.log("total length inch : "+len);   
                //len = len);
                //console.log("total length inch : "+len);  
                  
                qty = $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-qty").children("input").val(); 
                $("#gutterLiningLength_ft").val(get_feet_value(len)); 
                $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-len").children("input.input-in").val(len);
       
                price = $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-item").children("input.price").val();

                var rrp = len*price;

                var finishColor = $(this).parent().parent("tr").children("td.td-finish-color").children("select").length;
                var finishRrp = 0;
                if(finishColor>0){ 
                    finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
                }

                if(qty>0){
                    rrp = rrp + (len*finishRrp*qty); 
                }else{
                    rrp = 0;
                }

                 
                $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

            }

            if($(this).parent().parent("tr").children("td.td-item").children("input.price").attr("category") !== undefined && $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("category").toLowerCase() == "posts"){
                    price = $(this).parent().parent("tr").children("td.td-item").children("input.price").val();
                    finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
                    qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val();
    
                    if(qty<1){
                        $(this).parent().parent("tr").children("td.td-rrp").children("input").val("0.00");  
                        //return;
                    }
                    
                    rrp = (price*qty*len)+(qty*len*finishRrp); 
                    //alert(rrp);
                    //console.log("rrp :"+rrp);
                    // console.log("RRP :"+rrp);
                    $(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

            }

            
            //console.log("qty: "+qty);
            //$(this).parent().parent("tr").children("td:last").val();
        });  
            
 
        compute_project_cost();  
        //$("#louvres-len").prop('readonly', true);

 
    }); 
 


    //Set event to the created select.desclist
    $(document).on("change","#output select.desclist, #output select.paint-list, #output select.webbing-list",function(e){ //alert("trigger");
        
        //trigger_cbo_item(e, this);
        qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val();
        len = $(this).parent().parent("tr").children("td.td-len").children("input.input-in[style!=display:none]").val();
        width = $("#widthid").val();            

        var rrp = 0;

        if(typeof(len) == 'undefined' || len==0 || isNaN(len)){
            len = 1;
        }   
         
        var price = 0; 
        var invID = "";
        var desc = "";
        var obj = $(this).parent().parent("tr").children("td.td-item").children("select").length;  
        if(obj>0){
            price = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price");
            invID = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").val();
            desc = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").text();
            category = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("category");
 
            if(category.toLowerCase()=="beams" || category.toLowerCase()=="intermediate"){  
                $(this).parent().parent("tr").children("td.td-webbing").children("select").show();
            }else{ 
                $(this).parent().parent("tr").children("td.td-webbing").children("select").hide();
            }

        }else{
            price = $(this).parent().parent("tr").children("td.td-item").children("input.price").val();
            invID = $(this).parent().parent("tr").children("td.td-item").children("input").attr("inventoryid");
            desc = $(this).parent().parent("tr").children("td.td-item").children("input").attr("desc");
        }
        
        var finishColor = $(this).parent().parent("tr").children("td.td-finish-color").children("select").length;
        var finishRrp = 0;
        if(finishColor>0){ 
            finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
            //console.log("finishrrp: "+finishRrp);
        } 

        var webbing = $(this).parent().parent("tr").children("td.td-webbing").children("select").length;
        var webbingRrp = 0;
        if(webbing>0){ 
            if($(this).parent().parent("tr").children("td.td-webbing").children("select").children("option:selected").val()=="Yes"){
                webbingRrp = Number($(this).parent().parent("tr").children("td.td-webbing").children("select").attr("webrrp")); 
            }
        }
         
        rrp = qty*len*price;
        rrp = rrp + (finishRrp*len*qty) + webbingRrp; 
        $(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
        //alert("invID: "+invID+" rrp: "+rrp);
        var category = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("category");
        id = $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");
        //console.log("category: "+category);//return;
         
        //console.log("category :"+category);
        // console.log("len :"+len);
        // console.log("price :"+price);
        // console.log("qty :"+qty);
        // console.log("finishRrp :"+finishRrp);
         
        if(typeof(category) !== 'undefined' && category.length>0 && category.toLowerCase()=="posts"){ 
             
            rrp = price*qty*len; 
            rrp = rrp + (finishRrp * qty * len);   
                $(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

            }else if(typeof(category) !== 'undefined' && category.length>0 && category.toLowerCase()=="lourves"){ //alert(invID);
            rrp = (price * qty * len) + (finishRrp*width*qty);  
            $(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
        }
         
 
        $(this).parent().parent("tr").children(".invent").val(invID);
        $(this).parent().parent("tr").children(".desc").val(desc);

        compute_project_cost();
         
    });

     
    //$("#output .qtylen").change(function(){ //alert("is trigger");
    $(document).on("change","#output input",function(e){     //alert("running here2");

        var category = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("category");
        //alert("running category:"+category);    
        if(category == "Louvers"){
            //This is not needed because the louver field has it's own event handler.
            return;
        }   
        //alert("still running");
        //var addedRrp = Number($(this).parent().parent("tr").children("td.td-rrp").children("input").val()) + Number($(this).attr("webrrp"));

        //$(this).parent().parent("tr").children("td.td-rrp").children("input").val(addedRrp);
        //alert($(this).val());
        var price = 0.00;
        var rrp = 0.00;
        var id = 0;
        var category = "";
        var qty = 0;
        var len = 0;
        var total_inch = 0;

        // if($(this).parent().parent("tr").children("td.td-ft").children("input.input-ft").length>0){
        //  total_inch = get_feet_to_inch($(this).val()); 
        //  $(this).parent().parent("tr").children("td.td-len").children("input.input-in").val(total_inch);
        // }

        qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val();
        len = $(this).parent().parent("tr").children("td.td-len").children("input.input-in[style!=display:none]").val();

        
        //$(this).parent().parent("tr").children("td.td-ft").children("input.input-ft").val(get_feet_value(len));
        //alert(qty);  
        if($(this).val().length>0){
            $(this).removeClass("field-warning"); 
        }else{  
            if($(this).hasClass('qtylen-disbursements')==false && $(this).attr("class")!="input-ft"){ 
                $(this).addClass("field-warning"); 
            }
        }
  
        //alert(len);
        if((typeof(len) == 'undefined' || len==0 || isNaN(len))){
            //Made this len=0 zero because this is an intensional edit compared to other function made it default to len=1 to be safe in computation.
            if($(this).parent().parent("tr").children("td.td-uom").children("input").val()=="Mtrs"){
                len = 0;
            }else{
                len = 1;
            }
            
            //$(this).parent().parent("tr").children("td.td-len").children("input.input-ft").val();
            //$(this).removeClass("field-warning"); 
             
        }

        var obj = $(this).parent().parent("tr").children("td.td-item").children("select").length; 
        
        if(obj>0){
            price = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price");
         }else{
            price = $(this).parent().parent("tr").children("td.td-item").children("input.price").val();
         }

        var finishColor = $(this).parent().parent("tr").children("td.td-finish-color").children("select").length;
        var finishRrp = 0;
        if(finishColor>0){ 
            finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
            //console.log("finishrrp: "+finishRrp);
        } 

        var webbing = $(this).parent().parent("tr").children("td.td-webbing").children("select").length;
        var webbingRrp = 0;
        if(webbing>0){ 
            if($(this).parent().parent("tr").children("td.td-webbing").children("select").children("option:selected").val()=="Yes"){
                webbingRrp = Number($(this).parent().parent("tr").children("td.td-webbing").children("select").attr("webrrp")); 
            }
        }

        c_item = $(this).parent().parent("tr").children("input.invent").val(); 
        
        if(c_item == "IRV64"){
            //alert("inv: "+c_item+" qty: "+qty +" len: "+len+" uprice:"+price+ "rrp: "+rrp);
            $("#IRV66_qty").val($(this).val());  

            _qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val();
            _price = parseFloat($("#IRV66_qty").parent().parent("tr").children("td.td-item").children("input.price").val()); 
            _rrp = _qty*_price; 
            $("#IRV66_qty").parent().parent("tr").children("td.td-rrp").children("input").val(_rrp.toFixed(2));

        }
        else{
            //console.log("inv: "+c_item+" qty: "+qty +" len: "+len+" uprice:"+price+ "rrp: "+rrp);
        } 

       
        rrp = qty*len*price;              

        //console.log("inv: "+c_item+" qty: "+qty +" len: "+len+" uprice:"+price+ "rrp: "+rrp);
        if(qty>0){
            rrp = rrp + (finishRrp*len*qty) + webbingRrp;  
        }else{
            $(this).parent().parent("tr").children("td.td-rrp").children("input").val("0.00"); 
        }
         
        //console.log(rrp);
        $(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

        var category = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("category");
        //category = $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("category");
        //console.log("len-category: "+category);//return;
         
        if(typeof(category) !== 'undefined' && category.length>0 && category.toLowerCase()=="posts"){ 
            //console.log("price: "+price+" finishRrp"+finishRrp);
                //Compute Gutter lining.
                     
                rrp = price*qty*len; 
            rrp = rrp + (finishRrp * qty * len);  
                //console.log("rrp :"+rrp);
                // console.log("RRP :"+rrp);
                $(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

            }

        compute_project_cost();  

    }); 
     
            //compute_project_cost();
            //set length to 4 for an trace js that modify the value. 
            //$( "#additional_post .td-len input").val("4"); 
     



    $(".webbing-list").change(function(){ //alert("is trigger");
        if($(this).val()=="Yes"){
            //alert($(this).attr("webrrp"));
            var addedRrp = Number($(this).parent().parent("tr").children("td.td-rrp").children("input").val()) + Number($(this).attr("webrrp"));

            $(this).parent().parent("tr").children("td.td-rrp").children("input").val(addedRrp.toFixed(2));

        }else{
            var addedRrp = Number($(this).parent().parent("tr").children("td.td-rrp").children("input").val()) - Number($(this).attr("webrrp"));

            $(this).parent().parent("tr").children("td.td-rrp").children("input").val(addedRrp.toFixed(2));
        }

        compute_project_cost();

    }); 


    $("#louvres-len_ft, #louvres-qty").change(function(){ //alert("is trigger louvres-len_ft");
        /*
        //set the number and cost for the louver
        var price = 0.00;
        var rrp = 0.00;
        var id = 0;
        var category = "";
        var qty = 0;
        var len = 0;

        qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val();
        len = $(this).parent().parent("tr").children("td.td-ft").children("input:visible").val();

        len = get_feet_to_inch(len);
        price = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price"); 
        finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
        
        rrp = qty*price*len;
        rrp = rrp + (finishRrp * len * qty); 

        // console.log("finishRrp: "+finishRrp); 
        // console.log("len: "+len);
        // console.log("qty: "+qty);
        // console.log("rrp: "+rrp);
        //alert("0:"+$(this).val());
        $(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

        //alert(len);        
        //COMPUTE ENDCAP qty and cost.
        id = $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");
        qty = qty*2; 
        //console.log(qty);
        $("#endcap-qty").val(qty.toFixed(0)); 
        */


        louverProcessEntry(this);


        /*           
        price = $("#endcap-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
        finishRrp = Number($("#endcap-qty").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

        rrp = qty*price;
        rrp = rrp + finishRrp;
        $("#endcap-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
     

        //COMPUTE PIVOT STRIP qty and cost.
        //len = Number($("#lengthid").val());
        //qty = Math.ceil((len*5*2)/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
        endcap_qty = $("#endcap-qty").val();
        qty = Math.ceil(endcap_qty/12);
        //console.log("PIVOT QTY: "+qty);
        $("#pivot-qty").val(qty);
           
        price = $("#pivot-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
        finishRrp = Number($("#pivot-qty").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

        var rrp = (qty*price)+finishRrp;
        $("#pivot-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));



        //COMPUTE LINK BAR.
        //len = Number($("#lengthid").val()); 
        //qty = Math.round((len*5*2)/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
        qty = $("#louvres-qty").val(); 
        qty = Math.ceil(qty/12);
        //console.log("PIVOT QTY: "+qty);
        $("#linkBar-qty").val(qty); 
           
        price = $("#linkBar-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
        finishRrp = Number($("#linkBar-qty").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

        var rrp = (qty*price)+finishRrp;
        $("#linkBar-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
        */

        compute_project_cost(); 

    });


    //$("#output .gutter-length, #output .gutter-qty").change(function(){   
    $(document).on("change","#output .gutter-length, #output .gutter-qty",function(e){  
        var len = 0;

        $("#output .td-ft .gutter-length").each(function(e){ //alert($(this).val());
            //console.log("gutter-length: "+get_feet_to_inch($(this).val()));  
            //alert($(this).val());
            if($(this).parent().parent("tr").children("td.td-qty").children("input").val()>0 && $(this).val().length>0){ //alert(Number(get_feet_to_inch($(this).val())));
                len = Number(len) + (Number($(this).parent().parent("tr").children("td.td-qty").children("input").val()) * Number(get_feet_to_inch($(this).val())));
            }
        });

        //console.log("total length inch : "+len);   
        //len = len);
        
          
        qty = $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-qty").children("input").val();
        $("#gutterLiningLength_ft").val(get_feet_value(len)); 
        $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-len").children("input.input-in").val(len);

        //console.log("total length inch : "+$("#gutterLiningLength_ft").parent().parent("tr").children("td.td-len").children("input.input-in").val());  
   
        price = $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-item").children("input.price").val();

        var rrp = len*price;

        var finishColor = $(this).parent().parent("tr").children("td.td-finish-color").children("select").length;
        var finishRrp = 0;
        if(finishColor>0){ 
            finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
        }

        if(qty>0){
            rrp = rrp + (len*finishRrp*qty); 
        }else{
            rrp = 0;
        }

         
        $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

    });
     


    $(".vergola-colour:first").change(function(){ //alert("is trigger vergola-colour");
        var sel = $(this).val();
        
        $(".vergola-colour").each(function(){
            $(this).val(sel);
        });  
         
    }); 
     
     
    $("#endcap-qty").change(function(){
            //console.log($("#louvres-len").val());
            //$("#louvres-len").val($("#dblengthid2").val() * $("#dblengthid2").val());
            qty = Number($(this).val());
            price = parseFloat($(this).parent().parent("tr").children("td.td-item").children("input.price").val()); 
            rrp = qty*price;

            $(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
            //console.log(rrp);
            compute_project_cost();

    });

    // Change Disburment TotalRRP and TotalCost on Any Input Update 
    //alert("end of init");
    selectedFramework = $("#framework option:selected").val();
    if(typeof(selectedFramework) == 'undefined'){
        selectedFramework = $("#framework").val();
    }

    if((selectedFramework == "Single Bay VR0" || selectedFramework == "Single Bay VR0 - Drop-In")){   
        //$("#singlebay_input input").prop('disabled', true);   
        //$("#singlebay_input input").hide();   
         
        $("#lengthid").val("0");
        $("#widthid").val("0");

        if(isCreating==0 || viewType == "edit"){
            $("#frameset").hide();
        }

        $(".listing-table tr .td-qty .qtylen-disbursements").children("input:text").each(function(){
              
            //$(this).val("1");
            //$(this).trigger("change");
            //alert("here a");
             
        });   


        //ADD DEFAULT VALUE  
        $(".listing-table tr .td-qty").children("input:text").each(function(){
            //alert("here 1");
            //$(this).val("1");
            //$(this).trigger("change");
             
        });    

        $("#length_ft").trigger("change");
        //alert("here a");
        //$("#lengthid").trigger("change");
        // if(isCreating==1){
        //  $("#singlebay_input input").val('0');
        // }
  
        
        //END ADD DEFAULT VALUE  


    }

    //Trigger after finish initialization..
    $( ".color_select" ).trigger( "change" );

    if($("#projectid").length>0){ //should only in create quote
        //alert("trigger each row length changes");
        //$( "#lengthid" ).trigger( "change" );
        compute_project_cost();
    }

    //alert("Done");
    $('.qtylen, .input-ft').attr('readonly', false);


    if (viewType == 'create' || viewType == 'edit') {
        $("#total_gst").attr('disabled', false);
        $("#total_gst").attr('readonly', false); 
        $("#total_gst").keyup(function() {
            compute_project_total_gst();
        });
    }
}); // END of jquery 1st init.
 


function compute_project_cost(){  
    //Compute sum of the project cost.
    var total_rrp = 0;
    var total_vergola = 0;
    var total_disbursement = 0;
    var total_gst = 0;
    var total_sum = 0;
    var sub_total = 0;

    $("#output .rrp").each(function() { 
        total_rrp += Number($(this).val()); 
    });

    $("#output .rrp-disbursement").each(function() {
        total_disbursement += Number($(this).val());
    });
 
    total_vergola = (total_rrp - total_disbursement) / 0.75;

    var com_sales_commission = total_vergola * 0.1;
    var com_sales_commission_ps = 0;
    var com_pay1 = com_sales_commission * 0.4;
    var com_pay2 = com_sales_commission * 0.3;
    var com_final = com_sales_commission * 0.3;
    var com_installer_payment = total_vergola * 0.13;
  
    sub_total = total_vergola + total_disbursement;   
    total_gst = (total_vergola+total_disbursement) * 0.1; 
    total_sum = sub_total + total_gst;  

    $("#total_rrp").val(total_rrp.toFixed(2));
    $("#total_vergola").val(total_vergola.toFixed(2));
    $("#sub_total").val(sub_total.toFixed(2));   
    $("#total_disbursement").val(total_disbursement.toFixed(2));
    $("#total_gst").val(total_gst.toFixed(2));
    $("#total_sum").val(total_sum.toFixed(2)); 

    //Compute payment 
    var payment_deposit = 1000;
    var total_sum_10_percent = total_sum * 0.1;
    if(payment_deposit>total_sum_10_percent){
        payment_deposit = total_sum_10_percent;
    }
    var payment_progress = total_sum * 0.65;
    var payment_final = total_sum - payment_deposit - payment_progress;

    $("#payment_deposit").val(payment_deposit.toFixed(2));
    $("#payment_progress").val(payment_progress.toFixed(2));
    $("#payment_final").val(payment_final.toFixed(2)); 

    $("#com_sales_commission").val(com_sales_commission.toFixed(2));
    $("#com_sales_commission_ps").val(com_sales_commission_ps.toFixed(2));
    $("#com_pay1").val(com_pay1.toFixed(2));
    $("#com_pay2").val(com_pay2.toFixed(2));
    $("#com_final").val(com_final.toFixed(2));
    $("#com_installer_payment").val(com_installer_payment.toFixed(2));
}


function compute_project_total_gst(){  
    var sub_total = $("#sub_total").val();
    var total_gst = $("#total_gst").val();
    var total_sum = 0.0;

    if (total_gst.length == 0 || isNaN(total_gst) === true) {
        compute_project_cost();
    } else {
        if (sub_total.length == 0 || isNaN(sub_total) === true) {
            compute_project_cost();
        } else {
            total_sum = parseFloat(sub_total) + parseFloat(total_gst);
            $("#total_sum").val(total_sum.toFixed(2)); 
        }
    }
}
 

function add_new_post(){ 
      
    $( "#additional_post tr" ).clone().insertBefore( "#framework_last_row" );
      
    $(".added-post-tr .added_item").click(function(){ 
        $(this).parent().parent().remove();
        compute_project_cost(); 
    });   

    $("input.input-ft").change(function(e) {    
        var ft_val = $(this).val().length>0?$(this).val():0;
        var total_inch = 0; 
         
        if(ft_val.length>0){
            total_inch = get_feet_to_inch(ft_val); 
            $(this).parent().parent("tr").children("td.td-len").children("input").val(total_inch); 
        }else{
            $(this).parent().parent("tr").children("td.td-len").children("input").val("0");
        }  

    });

    $(".tbody_framework .added-post-tr:last select.desclist").trigger("change");

    $('.qtylen, .input-ft').bind('keypress', accept_number);
    $(".input-ft").bind('change',accept_max_inch);

}

function add_new_gutter(){
     
    $( "#additional_gutter tr" ).clone().insertBefore( "#gutter_last_row" );
      
    $(".added_item").click(function(){ 
        $(this).parent().parent().remove();
        $(".tbody_non_framework tr:nth-child(3) td.td-qty input.gutter-qty").trigger("change");
        compute_project_cost(); 
    }); 

     
    $("input.input-ft").change(function(e) {    
        var ft_val = $(this).val().length>0?$(this).val():0;
        var total_inch = 0; 
         
        if(ft_val.length>0){
            total_inch = get_feet_to_inch(ft_val); 
            $(this).parent().parent("tr").children("td.td-len").children("input").val(total_inch); 
        }else{
            $(this).parent().parent("tr").children("td.td-len").children("input").val("0");
        }  

    });

    $(".tbody_non_framework .added-gutter-tr:last select.desclist").trigger("change"); 
    $(".tbody_non_framework .added-gutter-tr:last td.td-qty input.gutter-qty").trigger("change");
    $('.qtylen, .input-ft').bind('keypress', accept_number);
    $(".input-ft").bind('change',accept_max_inch);

}

function add_new_non_standard_gutter(){
    
    //console.log($("#additional_none_standard_gutter tr").html());
    //$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
    $( "#additional_non_standard_gutter tr" ).clone().insertBefore( "#gutter_last_row" );
      
    $(".added_item").click(function(){ 
        $(this).parent().parent().remove(); 
        $(".tbody_non_framework tr:nth-child(3) td.td-qty input.gutter-qty").trigger("change");
        compute_project_cost(); 
    });

    $("input.input-ft").change(function(e) {    
        var ft_val = $(this).val().length>0?$(this).val():0;
        var total_inch = 0; 
         
        if(ft_val.length>0){
            total_inch = get_feet_to_inch(ft_val); 
            $(this).parent().parent("tr").children("td.td-len").children("input").val(total_inch); 
        }else{
            $(this).parent().parent("tr").children("td.td-len").children("input").val("0");
        }  

    });

    $(".tbody_non_framework .added-gutter-tr:last select.desclist").trigger("change");  
    $(".tbody_non_framework .added-gutter-tr:last td.td-qty input.gutter-qty").trigger("change");
    $('.qtylen, .input-ft').bind('keypress', accept_number);
    $(".input-ft").bind('change',accept_max_inch);

}

function add_new_flashing(){
    
    //console.log($("#additional_none_standard_gutter tr").html());
    //$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
    $( "#additional_flashing tr" ).clone().insertBefore( "#flashing_last_row" );
      
    $(".added_item").click(function(){ 
        $(this).parent().parent().remove(); 
        compute_project_cost(); 
    });

    $("input.input-ft").change(function(e) {    
        var ft_val = $(this).val().length>0?$(this).val():0;
        var total_inch = 0; 
         
        if(ft_val.length>0){
            total_inch = get_feet_to_inch(ft_val); 
            $(this).parent().parent("tr").children("td.td-len").children("input").val(total_inch); 
        }else{
            $(this).parent().parent("tr").children("td.td-len").children("input").val("0");
        }  

    });

    $(".tbody_non_framework .added-flashing-tr:last select.desclist").trigger("change");
    $('.qtylen, .input-ft').bind('keypress', accept_number);    
    $(".input-ft").bind('change',accept_max_inch);
}

function add_new_misc(){
    
    //console.log($("#additional_none_standard_gutter tr").html());
    //$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
    $( "#additional_misc tr" ).clone().insertBefore( "#misc_last_row" );
      
    $(".added_item").click(function(){ 
        $(this).parent().parent().remove();
        compute_project_cost(); 
    }); 

    $(".tbody_non_framework .added-misc-tr:last select.desclist").trigger("change");
    $('.qtylen, .input-ft').bind('keypress', accept_number);
}

function add_new_extra(){
    
    //console.log($("#additional_none_standard_gutter tr").html());
    //$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
    $( "#additional_extra tr" ).clone().insertBefore( "#extra_last_row" );
     

    $(".added_item").click(function(){ 
        $(this).parent().parent().remove();
        compute_project_cost(); 
    }); 

    $(".tbody_non_framework .added-extra-tr:last select.desclist").trigger("change");
    $('.qtylen, .input-ft').bind('keypress', accept_number);

}

 
function add_new_fixing(){
    
    //console.log($("#additional_none_standard_gutter tr").html());
    //$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
    $( "#additional_fixing tr" ).clone().insertBefore( "#fixing_last_row" );
      
    $(".added_item").click(function(){ 
        $(this).parent().parent().remove();
        compute_project_cost(); 
    }); 

    $(".tbody_framework .added-fixing-tr:last select.desclist").trigger("change"); 
    $('.qtylen, .input-ft').bind('keypress', accept_number);
}

function add_new_downpipe(){
    
    //console.log($("#additional_none_standard_gutter tr").html());
    //$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
    $( "#additional_downpipe tr" ).clone().insertBefore( "#downpipe_last_row" );
      
    $(".added_item").click(function(){ 
        $(this).parent().parent().remove();
        compute_project_cost(); 
    }); 

    $(".tbody_non_framework .added-downpipe-tr:last select.desclist").trigger("change"); 
    $('.qtylen, .input-ft').bind('keypress', accept_number);
}

function add_new_disbursement(){
    
    //console.log($("#additional_none_standard_gutter tr").html());
    //$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
    $( "#additional_disbursement tr" ).clone().insertBefore( "#disbursement_last_row" );
      
    $(".added_item").click(function(){ 
        $(this).parent().parent().remove();
        compute_project_cost(); 
    }); 

    $(".tbody_non_framework .added-disbursement-tr:last select.desclist").trigger("change");
    $('.qtylen, .input-ft').bind('keypress', accept_number);
}


$(".louver-item-qty, .louver-item-len").change(function(){  //#louvres-len_ft, #louvres-qty
        
        var endcap_qty = 0;
        var link_bar_qty = 0;
        $(".louver-item-qty").each(function(e){ 
            qty = Number($(this).val());
            link_bar_qty = link_bar_qty+qty;
            endcap_qty += qty*2;   
        });

        
 
        $("#endcap-qty").val(endcap_qty.toFixed(0)); 
        //$("#louvres-qty").val(qty); 
        qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val();  
        len = $(this).parent().parent("tr").children("td.td-ft").children("input:visible").val();
        len = get_feet_to_inch(len);
 

        price = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price"); 
        finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
        
        rrp = qty*price*len;
        rrp = rrp + (finishRrp * len * qty); 

        // console.log("finishRrp: "+finishRrp);
        // console.log("width: "+width);
        // console.log("len: "+len);
        // console.log("qty: "+qty);
        // console.log("rrp: "+rrp);
        //alert("0:"+$(this).val());
        $(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
        //alert("1:"+$(this).val());

        //COMPUTE ENDCAP qty and cost.
        //qty = qty*2; 
        //console.log(qty);
        //$("#endcap-qty").val(qty.toFixed(0)); 
           
        price = $("#endcap-qty").parent().parent("tr").children("td.td-item").children("input.price").val();  
        finishRrp = Number($("#endcap-qty").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
        qty = Number($("#endcap-qty").val());

        rrp = qty*price;
        rrp = rrp + finishRrp; 
        // console.log("qty: "+qty);
        // console.log("price: "+price);
        // console.log("rrp: "+rrp);
        $("#endcap-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
        //alert("endcap-qty rrp: "+$("#endcap-qty").parent().parent("tr").children("td.td-rrp").children("input").val());

        //COMPUTE PIVOT STRIP qty and cost.
        //len = Number($("#lengthid").val());
        //qty = Math.ceil(((len/39.37)*5*2)/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
        endcap_qty = $("#endcap-qty").val();
        qty = Math.ceil(endcap_qty/12);
        //console.log("PIVOT QTY: "+qty);
        $("#pivot-qty").val(qty);
           
        price = $("#pivot-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
        finishRrp = Number($("#pivot-qty").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

        var rrp = (qty*price)+finishRrp;
        $("#pivot-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

        //COMPUTE LINK BAR. 
        //len = Number($("#lengthid").val()); 
        //qty = Math.round((len*5*2)/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
        //qty = $("#louvres-qty").val(); 
        qty = Math.ceil(link_bar_qty/12); 
        //console.log("PIVOT QTY: "+qty); 
        $("#linkBar-qty").val(qty); 
        
        price = $("#linkBar-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
        finishRrp = Number($("#linkBar-qty").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

        var rrp = (qty*price)+finishRrp;
        $("#linkBar-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


        compute_project_cost();

    }); 


function add_new_louver(){
    
    //console.log($("#additional_none_standard_gutter tr").html());
    //$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
    var tr_index = 0;
    tr_index = tr_index + Number($( ".tr-added-item" ).length) + 1;
    //alert(tr_index);
 
    $( ".added-louver-tr" ).clone().addClass("tr-added-item tr-added-louver-item tr-louver-"+tr_index).insertBefore( "#vergola_last_row" );
    //$( ".added-pivot-strip-tr" ).clone().addClass("tr-added-louver-item tr-pivot-strip-"+tr_index).removeClass("added-pivot-strip-tr").insertBefore( "#vergola_last_row" );
    //$( ".added-link-bar-tr" ).clone().addClass("tr-added-louver-item tr-link-bar-"+tr_index).removeClass("added-link-bar-tr").insertBefore( "#vergola_last_row" );
      
    // $(".tr-louver-"+tr_index+" .td-qty input").addClass("louver-item-qty added-louvres-qty louvres-qty-"+tr_index).attr("index",tr_index);
    // // $(".tr-louver-"+tr_index+" .td-len input").addClass("added-louvres-len louvres-len-"+tr_index).attr("index",tr_index);
    // $(".tr-louver-"+tr_index+" .td-ft input").addClass("louver-item-len added-louvres-len louvres-len-"+tr_index).attr("index",tr_index);
    $(".tr-louver-"+tr_index+" .td-qty input").addClass("louver-item-qty added-louvres-qty louvres-qty-"+tr_index).attr("index",tr_index).attr("value",0);
    $(".tr-louver-"+tr_index+" .td-ft input").addClass("louver-item-len added-louvres-len louvres-len-"+tr_index).attr("index",tr_index).attr("value",0);
    $(".tr-louver-"+tr_index+" .td-qty input").removeClass("field-warning");

    //$(".tr-pivot-strip-"+tr_index+" .td-qty input").addClass("added-pivot-strip-qty pivot-strip-qty-"+tr_index).attr("index",tr_index);
       
    //$(".tr-link-bar-"+tr_index+" .td-qty input").addClass("added-link-bar-qty link-bar-qty-"+tr_index).attr("index",tr_index);
     
    $(".tbody_non_framework .added-louver-tr:last select.desclist").trigger("change");
    $( ".tr-louver-"+tr_index ).removeClass("added-louver-tr");

    $(".added_item").click(function(){ 
        //console.log($(this).parent().parent().next("tr").html());
        //$(this).parent().parent().next("tr").remove();
        //$(this).parent().parent().next("tr").remove();
        $(this).parent().parent().remove();
        
        //$(this).parent().parent().next().remove();
        
        $("#louvres-qty").trigger("change");

        compute_project_cost(); 
    }); 


    //alert("here0");
    $(".added-louvres-len, .added-louvres-qty").change(function(){
            /*
            //var item_index = "";
            //item_index = $(this).attr("index");
            //alert("here1");
            //set the number and cost for the louver
            var price = 0.00;
            var rrp = 0.00;
            var id = 0;
            var category = "";
            var qty = 0;
            var len = 0;


            id = $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");
            qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val();
            len = $(this).parent().parent("tr").children("td.td-ft").children("input:visible").val();
            len = get_feet_to_inch(len);
            
            // var is_len = $(this).hasClass("added-louvres-len");
            // if(is_len){ 
            //  len = get_feet_to_inch($(this).val());
            // } 

            price = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price");
            finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
            
            rrp = qty*price*len;
            rrp = rrp + (finishRrp * len * qty); 

            // console.log("finishRrp: "+finishRrp); 
            // console.log("len: "+len);
            // console.log("qty: "+qty);
            // console.log("rrp: "+rrp);
             
            $(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

            
            //All Additonal item reflected that are affected re-calculate.
            var total_louver_qty = 0;
            $(".louver-item-qty").each(function(e){ 
                qty = $(this).val();
                total_louver_qty += qty*2;   
            });
          
            $("#endcap-qty").val(total_louver_qty.toFixed(0)); 
               
            price = $("#endcap-qty").parent().parent("tr").children("td.td-item").children("input.price").val(); 
            finishRrp = Number($("#endcap-qty").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
            qty = Number($("#endcap-qty").val());
            
            rrp = qty*price;
            rrp = rrp + finishRrp;
            $("#endcap-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
         
            //COMPUTE PIVOT STRIP qty and cost.
            //len = Number($("#lengthid").val());
            //qty = Math.ceil((len*5*2)/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
            //$(".endcap-qty").val(qty*2);
            //endcap_qty = $("#endcap-qty").val();

            endcap_qty = Number($("#endcap-qty").val());
            pivot_qty = Math.ceil(endcap_qty/12); 

            
            $("#pivot-qty").val(pivot_qty); 
               
            price = $("#pivot-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
            //finishRrp = Number($("#pivot-qty").parent().parent("tr").children"(td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

            var rrp = (pivot_qty*price);
            $("#pivot-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
 
            //COMPUTE LINK BAR.
            //len = Number($(this).parent().parent("tr").children("td.td-len").children("input:visible").val()); 
            //qty = Math.round((len*5*2)/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
            //qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val();
            qty = Math.ceil(endcap_qty/24);
            //console.log("PIVOT QTY: "+qty);
            $("#linkBar-qty").val(qty); 
               
            price = $("#linkBar-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
            
            var rrp = (qty*price);
            $("#linkBar-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
            */


            louverProcessEntry(this);


            compute_project_cost(); 

         
    }); 

    //Add this same function for dynamic on the fly function attachment for new added input.
    // $("input.input-ft").change(function(e) {  
    //  //alert("inside .input-ft");
    //  //console.log($(this).val().length);
    //  var ft_val = $(this).val().length>0?$(this).val():0;
    //  var total_inch = 0; 
         
    //  if(ft_val.length>0){
    //      total_inch = get_feet_to_inch(ft_val); 
    //      $(this).parent().parent("tr").children("td.td-len").children("input").val(total_inch); 
    //  }else{
    //      $(this).parent().parent("tr").children("td.td-len").children("input").val("0");
    //  }
    //  //console.log('total_inch: '+total_inch);   

    // });

    $('.qtylen ,.input-ft').bind('keypress', accept_number);
    $(".input-ft").bind('change',accept_max_inch);
    
    // $('input.input-ft').bind('keypress', function (event) { 
         
    // });

    //$(".added-louvres-len").trigger("change");
 
}

 

$("input.input-ft").bind('change',accept_max_inch);

regexp = new RegExp("[0-9]+","g"); 

function accept_max_inch(event){
    var heightValue_array = this.value.match(regexp); 
    if(typeof(heightValue_array[1]) != 'undefined'){ 
        if(parseInt(heightValue_array[1])>12){ 
            this.value = this.value.substring(0,heightValue_array[0].length+1)+"12"; 
        }
    }
    //return (typeof(heightValue_array[0]) != 'undefined' ? parseInt(heightValue_array[0] *12) : 0) + (typeof(heightValue_array[1]) != 'undefined' ? parseInt(heightValue_array[1]) : 0);


    //var ft_val = $(this).val().length>0?$(this).val():0;
    var ft_val = this.value.length>0?this.value:0;
    
    var total_inch = 0; 
     
    if(ft_val.length>0){
        total_inch = get_feet_to_inch(ft_val); 
        $(this).parent().parent("tr").children("td.td-len").children("input").val(total_inch); 
    }else{
        $(this).parent().parent("tr").children("td.td-len").children("input").val("0");
    }
}
 


function get_feet_to_inch(f){  
    var heightValue_array = f.match(regexp); //alert(heightValue_array[1]);
    if(typeof(heightValue_array[1]) != 'undefined'){ 
        if(parseInt(heightValue_array[1])>12){ 
            //this.value = this.value.substring(0,heightValue_array[0].length+1)+"12"; 
            heightValue_array[1]=12;
        }
    }

    return (typeof(heightValue_array[0]) != 'undefined' ? parseInt(heightValue_array[0] *12) : 0) + (typeof(heightValue_array[1]) != 'undefined' ? parseInt(heightValue_array[1]) : 0);
}

function get_feet_value(inches){ 
    if(parseInt(inches)>0){  
        return Math.floor(inches / 12)+"'"+ Math.floor(inches %= 12); 
    }  
}

function get_inch_to_meter(inches){
    return (inches * 0.0254).toFixed(2);
     
}


function accept_number(event){
    var key = window.event ? event.keyCode : event.which; 

        switch (key) { 
            case 8:  // Backspace
            case 9:  // Tab
            case 13: // Enter
            case 37: // Left
            case 38: // Up
            case 39: // Right
            case 40: // Down
            case 116: // F5 refresh 
            case 45: // Delete
            break;
            default: 
           
              var theEvent = event || window.event;
              var key = theEvent.keyCode || theEvent.which;
              key = String.fromCharCode( key ); 
              var regex = /[0-9]/;
              if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
                //alert(key+" privented");
              }else{
                //alert(key+" allowed");
              }

             break;
        }
}


function louverGetOverallInfo() {
    var results = {
        "total_row": 0, 
        "total_qty": 0 
    };
    
    $("#[id^=louvres-qty]").each(function(e){ 
        results["total_row"] += 1;
        results["total_qty"] += parseInt($(this).val());
    });
    $(".louver-item-qty").each(function(e){ 
        results["total_row"] += 1;
        results["total_qty"] += parseInt($(this).val());
    });

    return results;
}


function louverProcessEndcap() {
    var overall_louver_info = louverGetOverallInfo();
    var total_endcap_qty = overall_louver_info["total_qty"] * 2;

    var endcap_cost = $("#endcap-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
    var endcap_paint_cost = Number($("#endcap-qty").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
    var total_endcap_price = (total_endcap_qty * endcap_cost) + endcap_paint_cost;

    $("#endcap-qty").val(total_endcap_qty.toFixed(0)); 
    $("#endcap-qty").parent().parent("tr").children("td.td-rrp").children("input").val(total_endcap_price.toFixed(2));
}


function louverProcessEntry(target_item) {
    var target_item_ref_type = "id";
    var target_item_ref = $(target_item).attr(target_item_ref_type);
    if (target_item_ref == undefined) {
        target_item_ref_type = "class";
        target_item_ref = $(target_item).attr(target_item_ref_type);
    }

    var selectedFramework = $("#framework option:selected").val();
    if (selectedFramework == undefined) {
        var selectedFramework = $("#framework").val();
    }

    var is_pivot_centralised = false;
    var is_link_bar_centralised = false;
    if (selectedFramework == "Single Bay VR0" || selectedFramework == "Single Bay VR0 - Drop-In") {
        var is_pivot_centralised = true;
        var is_link_bar_centralised = true;
    } else if (selectedFramework == "Single Bay VR1" || selectedFramework == "Single Bay VR1 - Drop-In") {
        var is_pivot_centralised = true;
        var is_link_bar_centralised = true;
    } else if (selectedFramework == "Double Bay VR2" || selectedFramework == "Double Bay VR2 - Drop-In") {
        var is_pivot_centralised = false;
        var is_link_bar_centralised = false;
    } else if (selectedFramework == "Double Bay VR3" || selectedFramework == "Double Bay VR3 - Drop-In" ) {
        var is_pivot_centralised = false;
        var is_link_bar_centralised = false;
    } else if (selectedFramework == "Double Bay VR3 - Gutter" || selectedFramework == "Double Bay VR3 - Gutter - Drop-In") {
        var is_pivot_centralised = false;
        var is_link_bar_centralised = false;
    }

    if (target_item_ref == 'louvres-qty' || 
        target_item_ref == 'louvres-len_ft') {

        //update shared endcap field
        // louverProcessEndcap();
        // return;
    }

    var louver_id = $(target_item).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");
    var louver_qty = $(target_item).parent().parent("tr").children("td.td-qty").children("input").val();
    var louver_cost = $(target_item).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price");
    var louver_paint_cost = Number($(target_item).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
    var louver_length = get_feet_to_inch($(target_item).parent().parent("tr").children("td.td-ft").children("input:visible").val());
    var louver_price = (louver_qty * louver_length * louver_cost) + (louver_qty * louver_length * louver_paint_cost);

    $(target_item).parent().parent("tr").children("td.td-rrp").children("input").val(louver_price.toFixed(2));

    if (is_pivot_centralised == true || is_link_bar_centralised == true) {
        var overall_louver_info = louverGetOverallInfo();
    }

    if (is_pivot_centralised == true) {
        var total_endcap_qty = overall_louver_info["total_qty"] * 2;
        var total_pivot_qty = Math.ceil(total_endcap_qty / 12);
        $("#pivot-qty").parent().parent("tr").children("td.td-qty").children("input").val(total_pivot_qty);
        var pivot_cost = $("#pivot-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
        var total_pivot_price = (total_pivot_qty * pivot_cost);
        $("#pivot-qty").parent().parent("tr").children("td.td-rrp").children("input").val(total_pivot_price.toFixed(2));
    } else {
        var endcap_qty = louver_qty * 2;
        var pivot_qty = Math.ceil(endcap_qty / 12);
        $(target_item).parent().parent("tr").next().children("td.td-qty").children("input").val(pivot_qty);
        var pivot_cost = $(target_item).parent().parent("tr").next().children("td.td-item").children("input.price").val();
        var pivot_price = (pivot_qty * pivot_cost);
        $(target_item).parent().parent("tr").next().children("td.td-rrp").children("input").val(pivot_price.toFixed(2));
    }

    if (is_pivot_centralised == true) {
        var total_link_bar_qty = Math.ceil(overall_louver_info["total_qty"] / 12);
        $("#linkBar-qty").parent().parent("tr").children("td.td-qty").children("input").val(total_link_bar_qty);
        var link_bar_cost = $("#linkBar-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
        var total_link_bar_price = (total_link_bar_qty * link_bar_cost);
        $("#linkBar-qty").parent().parent("tr").children("td.td-rrp").children("input").val(total_link_bar_price.toFixed(2));
    } else {
        var link_bar_qty = Math.ceil(louver_qty / 12);
        $(target_item).parent().parent("tr").next().next().children("td.td-qty").children("input").val(link_bar_qty);
        var link_bar_cost = $(target_item).parent().parent("tr").next().next().children("td.td-item").children("input.price").val();
        var link_bar_price = (link_bar_qty * link_bar_cost);
        $(target_item).parent().parent("tr").next().next().children("td.td-rrp").children("input").val(link_bar_price.toFixed(2));
    }

    //update shared endcap field
    louverProcessEndcap();
}
