var isCreating = 1; //check if the page is creating or viewing the quote. default for 1 for creating a quotation.

$(document).ready(function(){  
	var qty = 0;
	var len = 0;
	var price = 0;
	var rrp = 0;
	var obj = null;
	var id = 0; 
	var selectedFramework = $("#framework option:selected").val();
	var l1 = 0; var l2 = 0; var l3 = 0; 
	var isFirstLoad = 1;
	var viewType = "";

	$("script[src='singlebay.js']").remove();
	$("script[src='singlebay_vr1.js']").remove();
	$("script[src='doublebay.js']").remove();

	$('.qtylen, .input-ft').attr('readonly', true);
 
	$("td.td-len").css("display", "none");
	$("input.num, input.input-size").attr("autocomplete", "off");
  
	$('input.num, input.qtylen, input.length, input.width, .input-ft').bind('keypress', accept_number);
 
	var sel_colour = $(".color_select").children("option:selected").val();  
	$("select.colour").val(sel_colour); 
 
	
	$(".color_select").change(function() {  
		$("select.colour").val($(this).val()); 
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

	if(isCreating==1){  
			$("#dblengthid1").val(""); //empty the input dimension field if showing of created quote.
			$("#dblengthid2").val(""); 
			$("#dbwidthid1").val("");
			$("#dbbay").val("");

			//"#length1_ft, #length1_in, #length2_ft, #length2_in, #dbwidth_ft, #dbwidth_in, #dbbay"
			$("#length1_ft").val(""); //empty the input dimension field if showing of created quote.
			$("#length1_in").val("");
			$("#length2_ft").val(""); //empty the input dimension field if showing of created quote.
			$("#length2_in").val("");
			$("#dbwidth_ft").val(""); //empty the input dimension field if showing of created quote.
			$("#dbwidth_in").val("");
			$("#dbbay").val("");


			$(".lbay").remove();

			$(".listing-table tbody tr .td-qty").children("input:text").not( ".qtylen-disbursements" ).each(function(){
				 
	 			//console.log($(this).val());
				if($(this).val()=="0" || $(this).val().length<1){
					$(this).addClass("field-warning");
				}
			});
			 
	}else{ 
		selectedFramework = $("#framework").val();  
	}

	// if($(".show-form-disable").length>0){ 
	// 	$("#project input, #output input,#output select, #downbtn input").each(function(){ 
	// 			$(this).attr('disabled', true); 
	// 	});
	// }
	if($(".show-form-disable").length>0 || viewType=="read only"){

		$("#project input, #output input,#output select, .table-subtotal-holder input, #downbtn input").each(function(){
			//if($(".show-form").length==0){
				$(this).attr('disabled', true); 
			//}
		});		

		$("#cancel").attr('disabled', false);
		
	}

	if($("#frameworktype").length>0 && ($("#frameworktype").children("option:selected").val()=="Drop-In" || $("#frameworktype").val()=="Drop-In" )){
		//alert("here");
		$(".tbody_framework").remove();
	}
	  
	$("table.table-subtotal input").val("");
	$(".table-subtotal-holder").show();

	$("#projectcomm").hide();
	$("#projectcost").hide();
 
 	$("#dbwidthid1, #dbwidth_ft").focus(function(){
		$("#output input,#output select").each(function(e){
			$(this).removeAttr('disabled');
		});	

		if(selectedFramework == "Double Bay VR4"){ 
			//disable the master item row is won't into the database after saving.
			$("#cbeam_master input,#cbeam_master select, #gutter_master_l1 input, #gutter_master_l1 select, #gutter_master_l2 input, #gutter_master_l2 select, #poly_master input, #poly_master select, #poly_dummy input, #poly_dummy select").each(function(){ 
					$(this).attr('disabled', true); 
			}); 
		}
		
	});
 

	//$(".lbay").trigger("change");
	var length_total_inch = 0;
 	var width_total_inch = 0;
		
	$("#length1_ft, #length1_in, #length2_ft, #length2_in, #dbwidth_ft, #dbwidth_in").change(function(){  
		var nBay = 0;
	 
		if(Number($("#length1_ft").val())<1   || Number($("#length2_ft").val())<1   || Number($("#dbwidth_ft").val())<1   ){
			//alert("return");
			return;
		}else{

			length_total_inch = Number($("#length1_ft").val())*12 + Number($("#length1_in").val());	
			length2_total_inch = Number($("#length2_ft").val())*12 + Number($("#length2_in").val());	
	 		width_total_inch = Number($("#dbwidth_ft").val())*12 + Number($("#dbwidth_in").val());	

	 		//alert(length_total_inch);
	 		//set the meter value of the feet input.
	 		$("#dblengthid1").val(length_total_inch); 
	 		$("#dblengthid2").val(length2_total_inch); 
	 		$("#dbwidthid1").val(width_total_inch);
		}
		 
 
 
		// console.log("length_total_inch: "+length_total_inch);
		// console.log("length2_total_inch: "+length2_total_inch);
		// console.log("width_total_inch: "+width_total_inch);

        $('.length').each(function(){
           //$(this).val($('#dblengthid1').val());
           $(this).val(length_total_inch);
           $(this).parent().parent("tr").children("td.td-ft").children("input.input-ft").val(get_feet_value(length_total_inch));
        });

        $('.length2').each(function(){ 
           //$(this).val($('#dblengthid2').val()); 
           $(this).val(length2_total_inch);
           $(this).parent().parent("tr").children("td.td-ft").children("input.input-ft").val(get_feet_value(length2_total_inch));
        });
 
        $('.width').each(function(){
           //$(this).val($('#dbwidthid1').val());
           $(this).val(width_total_inch);
           $(this).parent().parent("tr").children("td.td-ft").children("input.input-ft").val(get_feet_value(width_total_inch));
        });
        

        
         
        if(selectedFramework == "Double Bay VR2" || selectedFramework == "Double Bay VR2 - Drop-In"){ //alert("003");
        	//var lw = Number($('#dblengthid1').val()) + Number($('#dblengthid2').val()); 

  			//var l1 = Number($('#dblengthid1').val());
        	//var l2 = Number($('#dblengthid2').val());
        	//var lw = (l1 + l2).toFixed(2); 

        	var l1 = length_total_inch; 
        	var l2 = length2_total_inch; 
        	var lw = length_total_inch + length2_total_inch;  

	        $("#cbeam_length").val(lw); 
	        $("#IRV43_length").val(lw);
	        $("#IRV45_length").val(lw);
	        $("#IRV46_length").val(lw); 

	        //$("#IRV27_length").val(lw);
	        $("#cbeam_length_ft").val(get_feet_value(lw));
	        $("#IRV43_length_ft").val(get_feet_value(lw));
	        $("#IRV45_length_ft").val(get_feet_value(lw));
	        $("#IRV46_length_ft").val(get_feet_value(lw)); 

	        //qty1 = 5*Math.floor(get_inch_to_meter(l1));
	        //qty2 = 5*Math.floor(get_inch_to_meter(l2));
	        qty1 = Math.ceil(l1/7.874);
	        qty2 = Math.ceil(l2/7.874);
	        

	        $("#louvres-qty-1").val(qty1);
	        $("#louvres-qty-2").val(qty2);
 

        }else if(selectedFramework == "Double Bay VR3" || selectedFramework == "Double Bay VR3 - Drop-In" ){
        	//var l1 = Number($('#dblengthid1').val());
        	//var l2 = Number($('#dblengthid2').val());
        	var l1 = length_total_inch; 
        	var l2 = length2_total_inch; 
        	var lw = (l1 + l2).toFixed(2); 
        	$("#louvres-len-1").val(l1); 
        	$("#louvres-len-2").val(l2); 

        	$("#louvres-len-1_ft").val(get_feet_value(l1));
        	$("#louvres-len-2_ft").val(get_feet_value(l2));

        	 
	        $("#cbeam_length").val(lw); 
	        //$("#IRV27_length").val(lw);

	        $("#IRV43_length").val(lw);
	        $("#IRV45_length").val(lw);
	        $("#IRV46_length").val(lw); 

	        $("#cbeam_length_ft").val(get_feet_value(lw));
	        $("#IRV43_length_ft").val(get_feet_value(lw));
	        $("#IRV45_length_ft").val(get_feet_value(lw));
	        $("#IRV46_length_ft").val(get_feet_value(lw)); 

	        
	        //$(".tapered_gutter_IRV29_30_length").val(lw); 
	        
	        $("#IRV44_l1").val(l1); 
	        $("#IRV44_l2").val(l2);

	        $("#IRV44_l1_ft").val(get_feet_value(l1)); 
	        $("#IRV44_l2_ft").val(get_feet_value(l2));  
 
	           
        }else if(selectedFramework == "Double Bay VR3 - Gutter" || selectedFramework == "Double Bay VR3 - Gutter - Drop-In"){
        	// var l1 = Number($('#dblengthid1').val());
        	// var l2 = Number($('#dblengthid2').val());
        	var l1 = length_total_inch; 
        	var l2 = length2_total_inch; 

        	var lw = (l1 + l2).toFixed(2); 
        	//$("#louvres-len-1").val($('#dblengthid1').val()); 
        	//$("#louvres-len-2").val($('#dblengthid2').val()); 
        	$("#louvres-len-1").val(l1);
        	$("#louvres-len-2").val(l2);

        	$("#louvres-len-1_ft").val(get_feet_value(l1));
        	$("#louvres-len-2_ft").val(get_feet_value(l2));
        	 
	        $("#cbeam_length").val(lw);  
	        $("#IRV43_length").val(lw);
	        $("#IRV45_length").val(lw);
	        $("#IRV46_length").val(lw); 

	        $("#cbeam_length_ft").val(get_feet_value(lw));
	        $("#IRV43_length_ft").val(get_feet_value(lw));
	        $("#IRV45_length_ft").val(get_feet_value(lw));
	        $("#IRV46_length_ft").val(get_feet_value(lw)); 

	        
	        //$(".tapered_gutter_IRV33_34_length").val(lw);  
	         
	        $("#IRV44_l1").val(l1); 
	        $("#IRV44_l2").val(l2); 

	        $("#IRV44_l1_ft").val(get_feet_value(l1)); 
	        $("#IRV44_l2_ft").val(get_feet_value(l2)); 

	         
        } 
        
        //$("#dbwidthid1").val(lw);
        //$("#gutterLining_len").val($('#dbwidthid1').val());
        

        $("#output .rrp").each(function(){ //alert("trigger rrp item computation");
        	var rrp = 0;
		 	//console.log($(this).parent().parent("tr").children("td.td-rrp").html());
		 	qty = Number($(this).parent().parent("tr").children("td.td-qty").children("input").val());
		 	//len = $(this).parent().parent("tr").children("td.td-len").children("input:visible").val();
		 	len = Number($(this).parent().parent("tr").children("td.td-len").children("input.input-in[style!=display:none]").val());
		 	obj = $(this).parent().parent("tr").children("td.td-item").children("select").length;
		 	id = $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");
 
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

			if(typeof(len) == 'undefined' || len<1 || isNaN(len)){
				len = 1;
			}	

		 	rrp = qty*len*price;
 
		 	//make sure the qty has 1 before including the finish rrp.
		 	if(qty>0){
		 		rrp = rrp + (finishRrp*len*qty) + webbingRrp; 
		 	}
   
		 	$(this).val(rrp.toFixed(2));

		 	selectedFramework = $("#framework option:selected").val();
		 	if(typeof(selectedFramework) == 'undefined'){
		 		selectedFramework = $("#framework").val();
		 	}
 			
		 	// if(isCreating == 0 && isFirstLoad==1){ //run here if 1st view of created quote 
		 	// 	alert("005-isCreating");
		 	// 	category = $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("category");
  
			 // 	if(typeof(category) !== 'undefined' && category.length>0 && category.toLowerCase()=="posts"){ 
			 // 		finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));	
			 // 		//console.log("price: "+price+" finishRrp"+finishRrp);
		 	// 		//Compute Gutter lining.
		 	// 	// 	console.log("1price :"+price);
				// 	// console.log("1qty :"+qty);
				// 	// console.log("1finishRrp :"+finishRrp);
					 
		 	// 		rrp = price*qty*len; 
				//  	rrp = rrp + (finishRrp*qty*len);   
		 	// 		$(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
		 
		 	// 	}

		 	// 	var invID = $(this).parent().parent("tr").children("td.td-item").children(".price").attr("inventoryid");
				// //alert(invID);
				// // if(invID=="IRV3"){
				// // 	console.log("price: "+price);
				// // 	console.log("width: "+width_total_inch);
				// // 	console.log("len: "+len);
				// // 	console.log("qty: "+qty);
				// // 	console.log("rrp: "+rrp); 
				// // }
				

				// if(typeof(invID) !== 'undefined' && category == "Louvers"){
 
				// 	if(selectedFramework == "Double Bay VR2" || selectedFramework == "Double Bay VR2 - Drop-In"){

				// 		//w = Number($("#dbwidthid1").val());
				// 		w = width_total_inch;
				// 		//$("#louvres-len-1").val($('tr.trv-1 td input.price').attr("length")); 
    //     				//$("#louvres-len-2").val($('tr.trv-2 td input.price').attr("length")); 
				// 		//w = $(this).parent().parent("tr").children("td.td-len").children("input:visible").val();
				// 		// console.log("w :"+w);
				// 		// console.log("price :"+price);
				// 		// console.log("qty :"+qty);
				// 		// console.log("finishRrp :"+finishRrp);
						  
				// 		rrp = (price * qty * w) + (finishRrp*w*qty); 
				// 	}else if(selectedFramework == "Double Bay VR3" || selectedFramework == "Double Bay VR3 - Gutter"){
				// 		//len = $(this).parent().parent("tr").children("td.td-len").children("input").val(); 
				// 		len = Number($(this).parent().parent("tr").children("td.td-len").children("input.input-in").val());
				// 		//alert(len);
				// 		rrp = (price * qty * len) + (finishRrp*len*qty); 
				// 	}  
					 
				// 	$(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
				// }


		 	// //console.log(selectedFramework+" "+$(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid")); 
		 	// }else 

		 	if((selectedFramework == "Double Bay VR2" || selectedFramework == "Double Bay VR2 - Drop-In" || selectedFramework == "Double Bay VR4")){
		 		//alert("005");
		 		//console.log("Inside louvers"); 
		 		//alert("HERE");
		 		if($(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid") == undefined){
		 			return true;
		 		}
		 		
		 		id = $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");
		 		var category = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("category");
		 		//alert(id); 
		 		if(typeof(category) !== 'undefined' && category.length>0 && category.toLowerCase()=="posts"){ 
			 		//console.log("price: "+price+" finishRrp"+finishRrp);
		 			//Compute Gutter lining.
		 			finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));	
		 			      
					// console.log("price :"+price);
					// console.log("qty :"+qty);
					// console.log("finishRrp :"+finishRrp);
					  
		 			rrp = price*qty*len; 
				 	rrp = rrp + (finishRrp*qty*len);  
		 			$(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
		 
		 		}

		 		if(category == "Louvers"){  
		 			//set the number and cost for the louver
		 			if(selectedFramework == "Double Bay VR2" || selectedFramework == "Double Bay VR2 - Drop-In"){
		 				//len1 = Number($("#dblengthid1").val());// + Number($("#dblengthid2").val());  
		 				//len2 = Number($("#dblengthid2").val());// + Number($("#dblengthid2").val()); 
		 				len1 = $("#louvres-len-1").val();
		 				len2 = $("#louvres-len-2").val();
		 			} 
		 			

		 			if(selectedFramework == "Double Bay VR2" || selectedFramework == "Double Bay VR2 - Drop-In" ){ //alert("HERE A1");
			 			//Compute louvers for length
			 			//len1 = $("#dblengthid1").val();  
			 			  
		 				qty1 = $("#louvres-qty-1").val(); 	

		 				price = Number($("#louvres-qty-1").parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price"));
		 				//alert(price);
		 				 
					 	finishRrp = Number($("#poly1").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
					 	//w = $(this).parent().parent("tr").children("td.td-len").children("input:visible").val();
					 	//w = Number($("#dbwidthid1").val());
					 	w = width_total_inch;

					 	rrp = qty1*price*w;
					 // 	console.log("w :"+w);
						// console.log("price :"+price);
						// console.log("qty :"+qty1);
						// console.log("finishRrp :"+finishRrp);
						// console.log("rrp :"+rrp);
  
						rrp = rrp+(finishRrp*w*qty1); //alert("rrp: "+rrp+" finish: "+finishRrp+" w:"+w+" qty1:"+qty1+ " (finishRrp*w*qty1): "+(finishRrp*w*qty1)); 
		 				$("#louvres-qty-1").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


		 				//Compute 3nd louvers for width 
		 				//len2 = $("#dblengthid2").val();
			 			//qty2 = Math.floor(5*len2);//Number($("#louvres-qty").val());  
		 				qty2 = $("#louvres-qty-2").val(); 
		 				
		 				price = Number($("#louvres-qty-2").parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price")); 
			 			
			 			//console.log("qty2: "+qty2+" price:"+price);
			 			 
						finishRrp = Number($("#poly2").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
						rrp = qty2*price*w; 
					 	rrp = rrp+(finishRrp*w*qty2); 
					 	 

			 			$("#louvres-qty-2").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
	 
		 				len = len1 + len2;
		 				qty = qty1 + qty2; 

		 			  
	 				}else if(selectedFramework == "Double Bay VR4"){
	 					//Compute louvers for length
	 					qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val();
			 			price = Number($("#louvres-qty-1").parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price")); 
			 			
			 			//alert(qty);
			 			rrp = qty*price;
			 			$(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

		 				 
		 				len = len1 + len2;
		 				qty = qty1 + qty2;
		 				 
	 				}


	 				//compute endcap qty and cost.
		 			qty = (Number(qty1)+Number(qty2))*2;
		 		// 	console.log("qty1 :"+qty1);
					//console.log("qty2 :"+qty2);
					//console.log("qty1 :"+qty1);
		 			//console.log(qty);
		 			$("#endcap-qty").val(qty.toFixed(0));  
			 		price = $("#endcap-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
			 		finishRrp = Number($("#pivot-qty-1").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

		 			rrp = qty*price+finishRrp;
		 			$("#endcap-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

		 			//compute 1st pivot qty and cost. 
		 			//qty = len; //Every 5 lourves have 1 pivot strip
		 			//qty = Math.ceil((len*5*2)/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
		 			qty = Math.ceil((qty1*2)/12);
		 			//console.log(qty);
		 			$("#pivot-qty-1").val(qty);  
			 		price = $("#pivot-qty-1").parent().parent("tr").children("td.td-item").children("input.price").val(); 
			 		finishRrp = Number($("#pivot-qty-1").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

		 			rrp = qty*price+finishRrp;
		 			$("#pivot-qty-1").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

		 			//compute 2nd pivot qty and cost.  
		 			qty = Math.ceil((qty2*2)/12);
		 			//console.log(qty);
		 			$("#pivot-qty-2").val(qty);  
			 		price = $("#pivot-qty-2").parent().parent("tr").children("td.td-item").children("input.price").val(); 
			 		finishRrp = Number($("#pivot-qty-2").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
		 			rrp = qty*price+finishRrp;
		 			$("#pivot-qty-2").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
 
		 			
		 			//1st link bar 
		 			qty = Math.ceil(qty1/12);
		 			//console.log("PIVOT QTY: "+qty);
		 			$("#linkBar-qty-1").val(qty);  
			 		price = $("#linkBar-qty-1").parent().parent("tr").children("td.td-item").children("input.price").val();

		 			rrp = qty*price;
		 			$("#linkBar-qty-1").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


		 			//2nd link bar 
		 			qty = Math.ceil(qty2/12); 
		 			$("#linkBar-qty-2").val(qty);  
			 		price = $("#linkBar-qty-2").parent().parent("tr").children("td.td-item").children("input.price").val();

		 			rrp = qty*price;
		 			$("#linkBar-qty-2").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

 
		 			//compute link bar. 
		 			var no_louvers = (qty1+qty2);
		 			//console.log("no_louvers: "+no_louvers);
		 			qty = Math.ceil(no_louvers/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
		 			//console.log("link bay QTY: "+qty);
		 			$("#linkBar-qty").val(qty); 
		 			   
			 		price = $("#linkBar-qty").parent().parent("tr").children("td.td-item").children("input.price").val();

		 			var rrp = qty*price;
		 			$("#linkBar-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
 
		 		} 

		 		 
		 		// if(id == "IRV31"  ){ 
		 		// 	var len = 0;

			 	// 	$(".gutter-length").each(function(e){  
			 	// 		len = len + Number($(this).parent().parent("tr").children("td.td-qty").children("input").val()) * Number($(this).val());
			 	// 	});
			 		  
					// qty = $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-qty").children("input").val();
					// $("#gutterLiningLength_ft").val(len.toFixed(2)); 
					// $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-len").children("input.input-in").val(len);
						   
			 	// 	price = $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-item").children("input.price").val();

					// var rrp = len*price;

					// var finishColor = $(this).parent().parent("tr").children("td.td-finish-color").children("select").length;
					// var finishRrp = 0;
				 // 	if(finishColor>0){ 
					//  	finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
					// }

					// if(qty>0){
				 // 		rrp = rrp + (len*finishRrp*qty); 
				 // 	}else{
				 // 		rrp = 0;
				 // 	}

					 
					// $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
		 			

		 		// }
 

		 	}else if((selectedFramework == "Double Bay VR3" || selectedFramework == "Double Bay VR3 - Gutter" || selectedFramework == "Double Bay VR3 - Drop-In" || selectedFramework == "Double Bay VR3 - Gutter - Drop-In") && $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid") !== undefined){
		 		 
		 		id = $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");
		 		var category = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("category");

		 		if(typeof(category) !== 'undefined' && category.length>0 && category.toLowerCase()=="posts"){ 
			 		//console.log("price: "+price+" finishRrp"+finishRrp);
		 			//Compute Gutter lining.
		 			     
		 			rrp = price*qty*len; 
				 	rrp = rrp + (finishRrp*qty*len);   
		 			$(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2)); 
		 		}

		 		if(category == "Louvers"){
		 			var rrp = 0;
		 			var len = 0;

		 			//console.log("Inside here IRV54");
		 			//l1 = Number($("#dbwidthid1").val()); //* Number($("#dbwidthid1").val())
		 			//l2 = Number($("#dbwidthid1").val());

		 			//len1 = Number($("#dblengthid1").val());//* Number($("#dbwidthid1").val())
		 			//len2 = Number($("#dblengthid2").val());
		 			len1 = $("#louvres-len-1").val();
		 			len2 = $("#louvres-len-2").val();


		 			//$("#louvres-qty-1").val(Math.floor(get_inch_to_meter(l1)*5));
		 			//$("#louvres-qty-2").val(Math.floor(get_inch_to_meter(l2)*5));
		 			 
		 			//console.log("l2:");console.log(l2);

		 			//if(len==1){len=2;}
		 			//qty1 = Math.floor(get_inch_to_meter(l1)*5);	
		 			//qty2 = Math.floor(get_inch_to_meter(l2)*5); 
		 			qty1 = Math.ceil(width_total_inch/7.874);
		 			qty2 = Math.ceil(width_total_inch/7.874);

			       	$("#louvres-qty-1").val(qty1);
			        $("#louvres-qty-2").val(qty2);
		 			
		 			priceL1 = $("#louvres-qty-1").parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price");
		 			 
		 		// 	console.log("priceL1: "+priceL1); 
		 		// 	console.log("qty1 :"+qty1);
					// console.log("priceL1 :"+priceL1);
					// console.log("len1 :"+len1);
		 			rrp = qty1*priceL1*len1;
		 			//console.log("rrp :"+rrp);	
		 			// console.log("----------");	
		 			var finishColor = $(this).parent().parent("tr").children("td.td-finish-color").children("select").length;
					var finishRrp = 0;
				 	if(finishColor>0){ 
					 	finishRrp = Number($("#louvres-qty-1").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
					 	//console.log("finishrrp: "+finishRrp);
					}
 	
 					// console.log("len1 :"+len1);
					// console.log("priceL1 :"+priceL1);
					// console.log("qty1 :"+qty1);
					// console.log("finishRrp :"+finishRrp);
					// console.log("rrp :"+rrp);

					rrp = rrp+(finishRrp*len1*qty1); 
					//console.log("louvres-qty-1 l1: "+l1);


		 			$("#louvres-qty-1").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


		 			priceL2 = $("#louvres-qty-2").parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price");
		 			rrp = qty2*priceL2*len2;	

		 			var finishColor = $(this).parent().parent("tr").children("td.td-finish-color").children("select").length;
					var finishRrp = 0;
				 	if(finishColor>0){ 
					 	finishRrp = Number($("#louvres-qty-2").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
					 	//console.log("finishrrp: "+finishRrp);
					}
 
					rrp = rrp+(finishRrp*len2*qty2); 
					//console.log("louvres-qty-2 l2: "+l2);

		 			$("#louvres-qty-2").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
		 			 

		 			//compute endcap qty and cost.
		 			//l1 = len1; //Number($("#dblengthid1").val());
		 			//l2 = len2; //Number($("#dblengthid2").val());
		 			qty = Math.floor(qty1*2)+Math.floor(qty2*2);
		 			//console.log("qty l1:"+l1*5*2);
		 			//console.log("qty l2:"+l2*5*2);
		 			$("#endcap-qty").val(qty.toFixed(0)); 
		 			   
			 		price = $("#endcap-qty").parent().parent("tr").children("td.td-item").children("input.price").val();

		 			rrp = qty*price;
		 			$("#endcap-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
		 			 
	 				   
		 			//compute 1st pivot qty and cost. 
		 			//qty = len; //Every 5 lourves have 1 pivot strip
		 			qty = Math.ceil((qty1*2)/12);
		 			//console.log(qty);
		 			$("#pivot-qty-1").val(qty);  
			 		price = $("#pivot-qty-1").parent().parent("tr").children("td.td-item").children("input.price").val(); 
		 			rrp = qty*price;
		 			$("#pivot-qty-1").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

		 			//compute 2nd pivot qty and cost.  
		 			qty = Math.ceil((qty2*2)/12);
		 			//console.log(qty);
		 			$("#pivot-qty-2").val(qty);  
			 		price = $("#pivot-qty-2").parent().parent("tr").children("td.td-item").children("input.price").val(); 
		 			rrp = qty*price;
		 			$("#pivot-qty-2").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


		 			//1st link bar 
		 			qty = Math.ceil(qty1/12);
		 			//console.log("PIVOT QTY: "+qty);
		 			$("#linkBar-qty-1").val(qty);  
			 		price = $("#linkBar-qty-1").parent().parent("tr").children("td.td-item").children("input.price").val();

		 			rrp = qty*price;
		 			$("#linkBar-qty-1").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


		 			//2nd link bar 
		 			qty = Math.ceil(qty2/12); 
		 			$("#linkBar-qty-2").val(qty);  
			 		price = $("#linkBar-qty-2").parent().parent("tr").children("td.td-item").children("input.price").val();

		 			rrp = qty*price;
		 			$("#linkBar-qty-2").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
 
		 			 
		 			//compute link bar.
		 			//qty = Number($("#dblengthid1").val()) + Number($("#dblengthid2").val());
		 			//console.log("total qty :"+qty);
		 			//console.log("qty1: "+qty1+" qty2:"+qty2);
		 			var no_louvers = (qty1+qty2);
		 			//console.log("no_louvers: "+no_louvers);
		 			qty = Math.ceil(no_louvers/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
		 			//console.log("link bay QTY: "+qty);
		 			$("#linkBar-qty").val(qty); 
		 			   
			 		price = $("#linkBar-qty").parent().parent("tr").children("td.td-item").children("input.price").val();

		 			var rrp = qty*price;
		 			$("#linkBar-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2)); 

		 		}

  
			}
			//end L1, L2, width change
		   	 
		   	id = $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");
			if(id == "IRV31"){ 

	 			var len = 0;

		 		$("#output .td-ft .gutter-length").each(function(e){ 
		 			if($(this).parent().parent("tr").children("td.td-qty").children("input").val()>0 && $(this).val().length>0){ 
			 			len = len + Number($(this).parent().parent("tr").children("td.td-qty").children("input").val()) * Number(get_feet_to_inch($(this).val()));
			 		}
		 		}); 

		 		//console.log("total length inch : "+len);  

		 		  
				qty = $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-qty").children("input").val();
				$("#gutterLiningLength_ft").val(get_feet_value(len)); 
				$("#gutterLiningLength_ft").parent().parent("tr").children("td.td-len").children("input").val(len);
				//console.log("total length inch : "+$("#gutterLiningLength_ft").parent().parent("tr").children("td.td-len").children("input").val());  	   
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
 		

		});

		
		

		
        //$("#louvres-len-1").prop('readonly', true);
        //$("#louvres-len-2").prop('readonly', true);
        //alert("init load: "+$('tr.trv-1 td input.price').attr("length"));
  		compute_project_cost();
  		isFirstLoad = 0; 

		
}); //END of L1, L2 and width changed  

 
	 
 

//console.log($( "#louvres-len").html()); 
//$(document).on("change","#louvres-len-2_ft, #louvres-qty-1, #louvres-qty-2").change(function(){
$("#louvres-len-1_ft, #louvres-len-2_ft, #louvres-qty-1, #louvres-qty-2").change(function(){
		/*
		//console.log($("#louvres-len").val());
		//$("#louvres-len").val($("#dblengthid2").val() * $("#dblengthid2").val());
		//alert("here0");
		if(isCreating){ 
			var selectedFramework = $("#framework option:selected").val();
		}else{  
			var selectedFramework = $("#framework").val();  
		} 

		 
		if((selectedFramework == "Double Bay VR2" || selectedFramework == "Double Bay VR2 - Drop-In" )){  
			//qty1 = $("#louvres-qty-1").val(); 	
			//qty1 = $(this).parent().parent("tr").children("td.td-qty").children("input").val();
		 	//len = $(this).parent().parent("tr").children("td.td-len").children("input").val();
		 	//len = Number($(this).parent().parent("tr").children("td.td-len").children("input.input-in[style!=display:none]").val());

	 	  	qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val();  
			price = Number($(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price"));
		 	finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
		 	//w = $(this).parent().parent("tr").children("td.td-len").children("input:visible").val();
		 	//w = Number($("#dbwidthid1").val());
		 	
		 	
		 	var id = $(this).attr('id');
		 	if(id == "louvres-len-1_ft" || id == "louvres-len-2_ft"){ 
		 		len = get_feet_to_inch($(this).val());

		 	}else{
		 		len = Number($(this).parent().parent("tr").children("td.td-len").children("input.input-in[style!=display:none]").val());
		 	}

		 	if(id == "louvres-qty-1"){ 
		 		qty1 = $(this).val();	
 				qty2 = $("#louvres-qty-2").val();
		 	}else if(id == "louvres-qty-2"){ 
		 		qty1 = $("#louvres-qty-1").val();	 
 				qty2 = $(this).val();
		 	} 
		 	

		 	rrp = qty*price*len;
		 	rrp = rrp+(finishRrp*len*qty); //alert("rrp: "+rrp+" finish: "+finishRrp+" w:"+w+" qty1:"+qty1+ " (finishRrp*w*qty1): "+(finishRrp*w*qty1)); 
			
		 // 	console.log("len :"+len);
			// console.log("price :"+price);
			 console.log("qty1 :"+qty1);
			  console.log("qty2 :"+qty2);
			// console.log("finishRrp :"+finishRrp); 
			// console.log("rrp :"+rrp);

			$(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

	 	  	 
			//compute endcap qty and cost.
 			//qty = (Number(qty1)+Number(qty2))*2;

 			qty = Math.floor(qty1*2)+Math.floor(qty2*2);  
 			$("#endcap-qty").val(qty.toFixed(0));  
 			 
	 		price = $("#endcap-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
	 		finishRrp = Number($("#pivot-qty-1").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

 			rrp = qty*price+finishRrp;
 			$("#endcap-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

 			//compute 1st pivot qty and cost. 
 			//qty = len; //Every 5 lourves have 1 pivot strip
 			//qty = Math.ceil((len*5*2)/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
 			qty = Math.ceil((qty1*2)/12);
 			//console.log(qty);
 			$("#pivot-qty-1").val(qty);  
	 		price = $("#pivot-qty-1").parent().parent("tr").children("td.td-item").children("input.price").val(); 
	 		finishRrp = Number($("#pivot-qty-1").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));

 			rrp = qty*price+finishRrp;
 			$("#pivot-qty-1").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

 			//compute 2nd pivot qty and cost.  
 			qty = Math.ceil((qty2*2)/12);
 			//console.log(qty);
 			$("#pivot-qty-2").val(qty);  
	 		price = $("#pivot-qty-2").parent().parent("tr").children("td.td-item").children("input.price").val(); 
	 		finishRrp = Number($("#pivot-qty-2").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
 			rrp = qty*price+finishRrp;
 			$("#pivot-qty-2").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

 			
 			//1st link bar 
 			qty = Math.ceil(qty1/12);
 			//console.log("PIVOT QTY: "+qty);
 			$("#linkBar-qty-1").val(qty);  
	 		price = $("#linkBar-qty-1").parent().parent("tr").children("td.td-item").children("input.price").val();

 			rrp = qty*price;
 			$("#linkBar-qty-1").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


 			//2nd link bar 
 			qty = Math.ceil(qty2/12); 
 			$("#linkBar-qty-2").val(qty);  
	 		price = $("#linkBar-qty-2").parent().parent("tr").children("td.td-item").children("input.price").val();

 			rrp = qty*price;
 			$("#linkBar-qty-2").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


 			//compute link bar. 
 			var no_louvers = (qty1+qty2);
 			//console.log("no_louvers: "+no_louvers);
 			qty = Math.ceil(no_louvers/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
 			//console.log("link bay QTY: "+qty);
 			$("#linkBar-qty").val(qty); 
 			   
	 		price = $("#linkBar-qty").parent().parent("tr").children("td.td-item").children("input.price").val();

 			var rrp = qty*price;
 			$("#linkBar-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

	 		  


	 	}else if((selectedFramework == "Double Bay VR3" || selectedFramework == "Double Bay VR3 - Gutter" || selectedFramework == "Double Bay VR3 - Drop-In" || selectedFramework == "Double Bay VR3 - Gutter - Drop-In") && $(this).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid") !== undefined){
	 		
	 		var rrp = 0;
 			var len = 0;
 			var l = 0; var l1 = 0; var l2 = 0;

 			//console.log("Inside here IRV54");
 			//l1 = Number($("#dbwidthid1").val()); //* Number($("#dbwidthid1").val())
 			//l2 = Number($("#dbwidthid1").val());

 			//len1 = Number($("#dblengthid1").val());//* Number($("#dbwidthid1").val())
 			//len2 = Number($("#dblengthid2").val());
 			// len1 = $("#louvres-len-1_ft").val();
 			// len2 = $("#louvres-len-2_ft").val();

 			qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val(); 
		 	//len = $(this).parent().parent("tr").children("td.td-len").children("input.input-in[style!=display:none]").val();
		 	var id = $(this).attr('id');
		 	if(id == "louvres-len-1_ft"){ 
		 		l1 = get_feet_to_inch($(this).val());
		 		qty1 = $("#louvres-qty-1").val();	
 				qty2 = $("#louvres-qty-2").val();

		 	}else if(id == "louvres-len-2_ft"){ 
		 		l2 = get_feet_to_inch($(this).val());
		 		qty1 = $("#louvres-qty-2").val();	
 				qty2 = $("#louvres-qty-2").val();

		 	}else if(id == "louvres-qty-1"){ 
		 		qty1 = $(this).val();	
 				qty2 = $("#louvres-qty-2").val();
		 	}else if(id == "louvres-qty-2"){ 
		 		qty1 = $("#louvres-qty-1").val();	 
 				qty2 = $(this).val();
		 	} 

		 	if(id == "louvres-len-1_ft" || id == "louvres-len-2_ft"){ 
		 		//len = get_feet_to_inch($(this).val()); 
		 		l = get_feet_to_inch($(this).val());
		 		//l = Number($(this).parent().parent("tr").children("td.td-len").children("input.input-in[style!=display:none]").val());
		 	}else{
		 		l = Number($(this).parent().parent("tr").children("td.td-len").children("input.input-in[style!=display:none]").val());
		 	}

		 	var rrp = 0;
 			var len = 0; 

 			qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val(); 
 			
 			priceL1 = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price");
 			 
 	  
 			rrp = qty*priceL1*l; 
 			
 			var finishColor = $(this).parent().parent("tr").children("td.td-finish-color").children("select").length;
			var finishRrp = 0;
		 	if(finishColor>0){ 
			 	finishRrp = Number($(this).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
			 	//console.log("finishrrp: "+finishRrp);
			}

			 
			rrp = rrp+(finishRrp*l*qty);  
 			$(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
 

 			//compute endcap qty and cost. 
 			qty = Math.floor(qty1*2)+Math.floor(qty2*2); 
 			$("#endcap-qty").val(qty.toFixed(0));  
 			   
	 		price = $("#endcap-qty").parent().parent("tr").children("td.td-item").children("input.price").val();

 			rrp = qty*price;
 			$("#endcap-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
 			 
				   
 			//compute 1st pivot qty and cost. 
 			//qty = len; //Every 5 lourves have 1 pivot strip
 			qty = Math.ceil((qty1*2)/12);
 			//console.log(qty);
 			$("#pivot-qty-1").val(qty);  
	 		price = $("#pivot-qty-1").parent().parent("tr").children("td.td-item").children("input.price").val(); 
 			rrp = qty*price;
 			$("#pivot-qty-1").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

 			//compute 2nd pivot qty and cost.  
 			qty = Math.ceil((qty2*2)/12);
 			//console.log(qty);
 			$("#pivot-qty-2").val(qty);  
	 		price = $("#pivot-qty-2").parent().parent("tr").children("td.td-item").children("input.price").val(); 
 			rrp = qty*price;
 			$("#pivot-qty-2").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


 			//1st link bar 
 			qty = Math.ceil(qty1/12);
 			//console.log("PIVOT QTY: "+qty);
 			$("#linkBar-qty-1").val(qty);  
	 		price = $("#linkBar-qty-1").parent().parent("tr").children("td.td-item").children("input.price").val();

 			rrp = qty*price;
 			$("#linkBar-qty-1").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


 			//2nd link bar 
 			qty = Math.ceil(qty2/12); 
 			$("#linkBar-qty-2").val(qty);  
	 		price = $("#linkBar-qty-2").parent().parent("tr").children("td.td-item").children("input.price").val();

 			rrp = qty*price;
 			$("#linkBar-qty-2").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

 			 
 			//compute link bar.
 			//qty = Number($("#dblengthid1").val()) + Number($("#dblengthid2").val());
 			//console.log("total qty :"+qty);
 			//console.log("qty1: "+qty1+" qty2:"+qty2);
 			var no_louvers = (qty1+qty2);
 			//console.log("no_louvers: "+no_louvers);
 			qty = Math.ceil(no_louvers/12); //pivot strip = no. of endcap / 12 (round up to the nearest unit.) ---(Every 5 lourves have 1 pivot strip-OLD formula)
 			//console.log("link bay QTY: "+qty);
 			$("#linkBar-qty").val(qty); 
 			   
	 		price = $("#linkBar-qty").parent().parent("tr").children("td.td-item").children("input.price").val();

 			var rrp = qty*price;
 			$("#linkBar-qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2)); 


		}
		*/

		louverProcessEntry(this);


			//console.log(rrp);
 		compute_project_cost();   
 		$(".input-ft").bind('change',accept_max_inch);

 		
});


	//Set event to the created select.desclist
		$(document).on("change","#output select.desclist, #output select.paint-list, #output select.webbing-list",function(e){// alert("trigger");

		 	//trigger_cbo_item(e, this);
		 	qty = $(this).parent().parent("tr").children("td.td-qty").children("input").val();
		 	//len = $(this).parent().parent("tr").children("td.td-len").children("input").val();
		 	len = Number($(this).parent().parent("tr").children("td.td-len").children("input.input-in[style!=display:none]").val());

		 	var price = 0; 
		 	var invID = "";
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

			var rrp = 0;
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
			 
			if(typeof(len) == 'undefined' || len==0 || isNaN(len)){
				len = 1;
			} 
		 	rrp = qty*len*price;
		 	rrp = rrp + (finishRrp*len*qty) + webbingRrp; 

		 // 	console.log("len :"+len);
			// console.log("price :"+price);
			// console.log("qty :"+qty);
			// console.log("finishRrp :"+finishRrp);
			// console.log("rrp :"+rrp);

		 	//alert(rrp);
		 	  
		 	$(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
		 	 
		 	var category = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("category");
	  
		 	if(typeof(category) !== 'undefined' && category.length>0 && category.toLowerCase()=="posts"){ 
		 		//console.log("price: "+price+" finishRrp"+finishRrp);
	 			//Compute Gutter lining.
	 			     
	 			rrp = price*qty*len; 
			 	rrp = rrp + (finishRrp*qty*len);   
	 			$(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
	 
	 		}else if(category == "Louvers"){
				if(isCreating){
					var selectedFramework = $("#framework option:selected").val();
				}else{ 
					var selectedFramework = $("#framework").val(); 
				}

				//alert(selectedFramework);

				if(selectedFramework == "Double Bay VR2" || selectedFramework == "Double Bay VR2 - Drop-In"){
					w = Number($("#dbwidthid1").val()); 

					rrp = (price * qty * w) + (finishRrp*w*qty); //alert(rrp);
				}else if(selectedFramework == "Double Bay VR3" || selectedFramework == "Double Bay VR3 - Gutter" || selectedFramework == "Double Bay VR3 - Drop-In" || selectedFramework == "Double Bay VR3 - Gutter - Drop-In"){
					// len = $(this).parent().parent("tr").children("td.td-len").children("input.input-in").val(); 
					rrp = (price * qty *len) + (finishRrp*len*qty); 
				} 

				$(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

			 	//SET Gutter Length
 				// var total_gutter_length = (Number($("#dblengthid1").val())+Number($("#dblengthid2").val())).toFixed(2);
	 			// $("#gutter1st").val(total_gutter_length);
	 			// $("#gutter2nd").val(total_gutter_length); 
	 			 
	 			// gutter1st_qty = Number($("#gutter1st").parent().parent("tr").children("td.td-qty").children("input").val());
	 			// gutter2nd_qty = Number($("#gutter2nd").parent().parent("tr").children("td.td-qty").children("input").val());
	 			// //compute the rrp for the 1st gutter
	 			// price = $("#gutter1st").parent().parent("tr").children("td.td-item").children("input.price").val();
	 			// finishRrp = Number($("#gutter1st").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
	 			 
	 			// rrp = (gutter1st_qty*price*total_gutter_length)+(finishRrp*total_gutter_length*gutter1st_qty); 
	 			// $("#gutter1st").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));

	 			// //compute the rrp for the 2st gutter
	 			// price = $("#gutter2nd").parent().parent("tr").children("td.td-item").children("input.price").val();
	 			// finishRrp = Number($("#gutter2nd").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
	 			 
	 			// rrp = (gutter2nd_qty*price*total_gutter_length)+(finishRrp*total_gutter_length*gutter2nd_qty); 
	 			// $("#gutter2nd").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


			}

	 		 $(this).parent().parent("tr").children(".invent").val(invID);
		 	 $(this).parent().parent("tr").children(".desc").val(desc);

		 	compute_project_cost();
		 	 
		});

	 
		//$("#output .qtylen").change(function(){ //alert("is trigger"); ,"#output .qtylen"
	 	$(document).on("change","#output input",function(e){ 	//alert("Trigger");
			//var addedRrp = Number($(this).parent().parent("tr").children("td.td-rrp").children("input").val()) + Number($(this).attr("webrrp"));
			var category = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("category");
			//alert("running category:"+category);	  
			if(category == "Louvers"){
				//This is not needed because the louver field has it's own event handler.
				return;
			}

			//$(this).parent().parent("tr").children("td.td-rrp").children("input").val(addedRrp);
		 	var price = 0.00;
		 	var rrp = 0.00;
		 	var id = 0;
		 	var category = "";
		 	var qty = 0;
		 	var len = 0;
 
		 	qty = Number($(this).parent().parent("tr").children("td.td-qty").children("input:visible").val());
			//len = $(this).parent().parent("tr").children("td.td-len").children("input:visible").val();
			len = Number($(this).parent().parent("tr").children("td.td-len").children("input.input-in[style!=display:none]").val());

			if($(this).val().length>0){
		 		$(this).removeClass("field-warning"); 
		 	}else{  
		 		if($(this).hasClass('qtylen-disbursements')==false){ 
		 			$(this).addClass("field-warning"); 
		 		}
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
		 	//$("#IRV66_qty").val($(this).val()); invent
		 	if(c_item == "IRV64"){
		 		//alert("inv: "+c_item+" qty: "+qty +" len: "++" uprice:"+price+ "rrp: "+rrp);
		 		$("#IRV66_qty").val($(this).val());
		 		_qty = $(this).val();
				_price = parseFloat($("#IRV66_qty").parent().parent("tr").children("td.td-item").children("input.price").val()); 
				//alert(price);
				_rrp = _qty*_price; 
				$("#IRV66_qty").parent().parent("tr").children("td.td-rrp").children("input").val(_rrp.toFixed(2));
		 	}else{
		 		//console.log(c_item);
		 	}  

		 	if(typeof(len) == 'undefined'){
				len = 1;
			}
		 	
		 	var category = $(this).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("category");
		 	//alert(category);
		 	if(typeof(category) !== 'undefined' && category.toLowerCase()=="posts"){
		 		rrp = qty*price*len;
		 		rrp = rrp + (finishRrp*qty*len);
		 		//alert("inside: 1 ="+rrp);
		 	}else if(typeof(len) !== 'undefined' && len>0){ //if the row item has a length
		 		rrp = qty*len*price;
		 		rrp = rrp + (finishRrp*len*qty) + webbingRrp;
		 		//alert("inside: 2");
		 	}else{
		 		rrp = qty*price;
		 		rrp = rrp + (finishRrp*qty) + webbingRrp;
		 		//alert("inside: 3");
		 	}
		 	   
		 	if(qty<1){
				$(this).parent().parent("tr").children("td.td-rrp").children("input").val("0.00"); 
		 	}
		  
		 	//console.log("inv: "+c_item+" qty: "+qty +" len: "+len+" uprice:"+price+ "rrp: "+rrp);
			//var invID = $(this).parent().parent("tr").children("td.td-item").children(".price").attr("inventoryid");
			//alert(category);
			// if(category == "Louvers"){ //alert("here 3");
			// 	if($(".show-form").length==0){
			// 		var selectedFramework = $("#framework option:selected").val();
			// 	}else{ 
			// 		var selectedFramework = $("#framework").val(); 
			// 	}

			// 	//alert(selectedFramework);

			// 	if(selectedFramework == "Double Bay VR2" || selectedFramework == "Double Bay VR2 - Drop-In"){ 
			// 		//w = Number($("#dbwidthid1").val()); 
			// 		w = Number($(this).parent().parent("tr").children("td.td-len").children("input.input-in").val()); 
			// 		rrp = (price * qty * w) + (finishRrp*w*qty); 
			// 	}else if(selectedFramework == "Double Bay VR3" || selectedFramework == "Double Bay VR3 - Gutter" || selectedFramework == "Double Bay VR3 - Drop-In" || selectedFramework == "Double Bay VR3 - Gutter - Drop-In"){
			// 		len = Number($(this).parent().parent("tr").children("td.td-len").children("input.input-in").val()); 
			// 		rrp = (price * qty) + (finishRrp*len*qty); 
			// 	} 
  
			// 	$(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
 
			// }
		 	 
		 	//console.log(rrp);
		 	$(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));
		 	compute_project_cost(); 
 

		});		
 		 
 
 
if($(".show-form").length==0){
	
} 

// if($( "#dblengthid1" ).val()>0 && $( "#dblengthid2" ).val()>0 && $( "#dbwidthid1" ).val()>0 && $("#projectid").length>0){ //should only in create quote
// 	//alert("trigger each row length changes");
// 	//$( "#lengthid" ).trigger( "change" );
// 	compute_project_cost();
// }


  

// $(".webbing-list").change(function(){ //alert("is trigger");
// 	if($(this).val()=="Yes"){
// 		//alert($(this).attr("webrrp"));
// 		var addedRrp = Number($(this).parent().parent("tr").children("td.td-rrp").children("input").val()) + Number($(this).attr("webrrp"));

// 		$(this).parent().parent("tr").children("td.td-rrp").children("input").val(addedRrp);

// 	}else{
// 		var addedRrp = Number($(this).parent().parent("tr").children("td.td-rrp").children("input").val()) - Number($(this).attr("webrrp"));

// 		$(this).parent().parent("tr").children("td.td-rrp").children("input").val(addedRrp);
// 	}

// 	compute_project_cost();

// });	


//$("#output .gutter-length, #output .gutter-qty").change(function(){
$(document).on("change","#output .gutter-length, #output .gutter-qty",function(e){ 	
	var len = 0;

	$("#output .td-ft .gutter-length").each(function(e){  
		if($(this).parent().parent("tr").children("td.td-qty").children("input").val()>0 && $(this).val().length>0){
			len = len + Number($(this).parent().parent("tr").children("td.td-qty").children("input").val()) * Number(get_feet_to_inch($(this).val()));
		}	
	}); 

	//console.log("total length inch : "+len);  

		  
	qty = $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-qty").children("input").val();
	$("#gutterLiningLength_ft").val(get_feet_value(len)); 
	$("#gutterLiningLength_ft").parent().parent("tr").children("td.td-len").children("input").val(len);

	//console.log("total length inch : "+$("#gutterLiningLength_ft").parent().parent("tr").children("td.td-len").children("input").val());  	   
		   
	price = $("#gutterLiningLength_ft").parent().parent("tr").children("td.td-item").children("input.price").val();

	//console.log("len: "+len+" price:"+price);  
	//console.log("inv: "+c_item+" qty: "+qty +" len: "+len+" uprice:"+price+ "rrp: "+rrp);
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
  

$(".vergola-colour:first").change(function(){ //alert("is trigger");
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

 
 
	//alert($("#projectid").length); 
	if($( "#length1_ft" ).val()>0 && $("#projectid").length>0){
		//alert("start trigger");
		//$( "#length1_ft" ).trigger( "change" );
		compute_project_cost(); 
	}
		
	//$('.qtylen, .input-ft').attr('readonly', false);	
	// if($( "#dblengthid2" ).val()>0 && $("#projectid").length==0){
	// 	$( "#dblengthid2" ).trigger( "change" );
	// }

	// if($( "#dbwidthid1" ).val()>0 && $("#projectid").length==0){
	// 	$( "#dbwidthid1" ).trigger( "change" );
	// }

 	$('.qtylen, .input-ft').attr('readonly', false);
	//alert("end of 1st init");


    if (viewType == 'create' || viewType == 'edit') {
        $("#total_gst").attr('disabled', false);
        $("#total_gst").attr('readonly', false); 
        $("#total_gst").keyup(function() {
            compute_project_total_gst();
        });
    }
});	//END of first jquery init.

 

//$("#IRV64_qty").change(function(){
	//alert($(this).val());
	//$("#IRV66_qty").val($(this).val()); 

	// qty = Number($(this).val()); 
	// price = parseFloat($(this).parent().parent("tr").children("td.td-item").children("input.price").val()); 
	// rrp = qty*price; 
	// $(this).parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


	// qty = Number($("#IRV66_qty").val()); 
	// price = parseFloat($("#IRV66_qty").parent().parent("tr").children("td.td-item").children("input.price").val()); 
	// rrp = qty*price; 
	// $("#IRV66_qty").parent().parent("tr").children("td.td-rrp").children("input").val(rrp.toFixed(2));


	// compute_project_cost();
//});	


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

	$("#sub_total").val(sub_total.toFixed(2));
	$("#total_rrp").val(total_rrp.toFixed(2));
	$("#total_vergola").val(total_vergola.toFixed(2));
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
	
	//console.log($("#additional_post").html());
	//$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );

	$( "#additional_post tr" ).clone().insertBefore( "#framework_last_row" );
	  

	$(".added_item").click(function(){ 
		$(this).parent().parent().remove();
		compute_project_cost(); 
	});	 

	//$(".tbody_framework .added-tr:last select.desclist option:first").prop('selected', true);
	

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
	$('.qtylen ,.input-ft').bind('keypress', accept_number);
	$(".input-ft").bind('change',accept_max_inch);
	 
}

function add_new_gutter(){
	
	//console.log($("#additional_gutter tr").html());
	//$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
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

	//console.log($(".tbody_non_framework .added-gutter-tr:last select.desclist").html());
	$(".tbody_non_framework .added-gutter-tr:last select.desclist").trigger("change");
	$(".tbody_non_framework .added-gutter-tr:last td.td-qty input.gutter-qty").trigger("change");

	$('.qtylen ,.input-ft').bind('keypress', accept_number);
	$(".input-ft").bind('change',accept_max_inch);

}

function add_new_non_standard_gutter(){
	
	//console.log($("#additional_none_standard_gutter tr").html());
	//$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
	$( "#additional_non_standard_gutter tr" ).clone().insertBefore( "#gutter_last_row" );
	//$("select.desclist").trigger("change");

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

	$('.qtylen ,.input-ft').bind('keypress', accept_number);
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
	$('.qtylen ,.input-ft').bind('keypress', accept_number);
	$(".input-ft").bind('change',accept_max_inch);

}

function add_new_misc(){
	
	//console.log($("#additional_none_standard_gutter tr").html());
	//$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
	$( "#additional_misc tr" ).clone().insertBefore( "#misc_last_row" );
	//$("select.desclist").trigger("change");

	$(".added_item").click(function(){ 
		$(this).parent().parent().remove();
		compute_project_cost(); 
	});	

	$(".tbody_non_framework .added-misc-tr:last select.desclist").trigger("change");
	$('.qtylen').bind('keypress', accept_number); 
}

function add_new_extra(){
	
	//console.log($("#additional_none_standard_gutter tr").html());
	//$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
	$( "#additional_extra tr" ).clone().insertBefore( "#extra_last_row" );
	//$("select.desclist").trigger("change");

	$(".added_item").click(function(){ 
		$(this).parent().parent().remove();
		compute_project_cost(); 
	});	

	$(".tbody_non_framework .added-extra-tr:last select.desclist").trigger("change");
	$('.qtylen').bind('keypress', accept_number); 
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
	$('.qtylen').bind('keypress', accept_number); 

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
	$('.qtylen').bind('keypress', accept_number); 
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
	$('.qtylen').bind('keypress', accept_number); 
}

function add_new_louver(){
	
	//console.log($("#additional_none_standard_gutter tr").html());
	//$( "#framework_last_row" ).appendTo( $( "#framework_last_row" )  );
	var tr_index = 0;
	tr_index = tr_index + Number($( ".tr-added-item" ).length) + 1;
	//alert(tr_index);
 
	$( ".added-louver-tr" ).clone().addClass("tr-added-item tr-added-louver-item tr-louver-"+tr_index).insertBefore( "#vergola_last_row" );
	$( ".added-pivot-strip-tr" ).clone().addClass("tr-added-louver-item tr-pivot-strip-"+tr_index).removeClass("added-pivot-strip-tr").insertBefore( "#vergola_last_row" );
	$( ".added-link-bar-tr" ).clone().addClass("tr-added-louver-item tr-link-bar-"+tr_index).removeClass("added-link-bar-tr").insertBefore( "#vergola_last_row" );
	  
	// $(".tr-louver-"+tr_index+" .td-qty input").addClass("louver-item-qty added-louvres-qty louvres-qty-"+tr_index).attr("index",tr_index);
	// $(".tr-louver-"+tr_index+" .td-len input").addClass("added-louvres-len louvres-len-"+tr_index).attr("index",tr_index);
	$(".tr-louver-"+tr_index+" .td-qty input").addClass("louver-item-qty added-louvres-qty louvres-qty-"+tr_index).attr("index",tr_index).attr("value",0);
	$(".tr-louver-"+tr_index+" .td-ft input").addClass("added-louvres-len louvres-len-"+tr_index).attr("index",tr_index).attr("value",0);

	$(".tr-pivot-strip-"+tr_index+" .td-qty input").addClass("added-pivot-strip-qty pivot-strip-qty-"+tr_index).attr("index",tr_index);
	$(".tr-link-bar-"+tr_index+" .td-qty input").addClass("added-link-bar-qty link-bar-qty-"+tr_index).attr("index",tr_index);

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
		 	// 	len = get_feet_to_inch($(this).val());
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

 		 	
            //compute endcap qty and cost.
 		 	//All Additonal item reflected that are affected re-calculate.
			// var total_louver_qty = 0;
			// $(".louver-item-qty").each(function(e){ 
			//  	qty = $(this).val();
			// 	total_louver_qty += qty*2;   
			// });
			// $("#endcap-qty").val(total_louver_qty.toFixed(0)); 

			var overall_louver_info = louverGetOverallInfo();
			var total_endcap_qty = overall_louver_info["total_qty"] * 2;
			$("#endcap-qty").val(total_endcap_qty.toFixed(0)); 

			   
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
	// 	//alert("inside .input-ft");
	// 	//console.log($(this).val().length);
	// 	var ft_val = $(this).val().length>0?$(this).val():0;
	// 	var total_inch = 0; 
		 
	// 	if(ft_val.length>0){
	// 		total_inch = get_feet_to_inch(ft_val); 
	// 		$(this).parent().parent("tr").children("td.td-len").children("input").val(total_inch); 
	// 	}else{
	// 		$(this).parent().parent("tr").children("td.td-len").children("input").val("0");
	// 	}
	// 	//console.log('total_inch: '+total_inch); 	

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
  

function get_feet_value(inches){ 
	if(parseInt(inches)>0){  
		return Math.floor(inches / 12)+"'"+ Math.floor(inches %= 12); 
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
            break;
            default: 
           
 			  var theEvent = event || window.event;
			  var key = theEvent.keyCode || theEvent.which;
			  key = String.fromCharCode( key ); 
			  var regex = /[0-9]|\./;
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

    var endcap_qty = total_endcap_qty;
    var endcap_cost = $("#endcap-qty").parent().parent("tr").children("td.td-item").children("input.price").val();
    var endcap_paint_cost = Number($("#endcap-qty").parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
    var endcap_price = (total_endcap_qty * endcap_cost) + endcap_paint_cost;

	$("#endcap-qty").val(total_endcap_qty.toFixed(0)); 
	$("#endcap-qty").parent().parent("tr").children("td.td-rrp").children("input").val(endcap_price.toFixed(2));
}


function louverProcessEntry(target_item) {
	var target_item_ref_type = "id";
	var target_item_ref = $(target_item).attr(target_item_ref_type);
	if (target_item_ref == undefined) {
		target_item_ref_type = "class";
		target_item_ref	= $(target_item).attr(target_item_ref_type);
	}

	if (target_item_ref == 'louvres-qty-1' || 
		target_item_ref == 'louvres-len-1_ft' || 
		target_item_ref == 'louvres-qty-2' || 
		target_item_ref == 'louvres-len-2_ft') {

		var target_item_index = '1';
		if (target_item_ref == 'louvres-qty-2' || 
			target_item_ref == 'louvres-len-2_ft') {
			var target_item_index = '2';
		} 

	    var louver_id = $(target_item).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");
	    var louver_qty = $(target_item).parent().parent("tr").children("td.td-qty").children("input").val();
	    var louver_cost = $(target_item).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price");
	    var louver_paint_cost = Number($(target_item).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
	    var louver_length = get_feet_to_inch($(target_item).parent().parent("tr").children("td.td-ft").children("input:visible").val());
	    var louver_price = (louver_qty * louver_length * louver_cost) + (louver_qty * louver_length * louver_paint_cost);

	    $(target_item).parent().parent("tr").children("td.td-rrp").children("input").val(louver_price.toFixed(2));
	                   
	    var endcap_qty = louver_qty * 2;

        var pivot_qty = Math.ceil(endcap_qty / 12);
        $("#pivot-qty-" + target_item_index).parent().parent("tr").children("td.td-qty").children("input").val(pivot_qty);
        var pivot_cost = $("#pivot-qty-" + target_item_index).parent().parent("tr").children("td.td-item").children("input.price").val();
        var pivot_price = (pivot_qty * pivot_cost);
        $("#pivot-qty-" + target_item_index).parent().parent("tr").children("td.td-rrp").children("input").val(pivot_price.toFixed(2));

        var link_bar_qty = Math.ceil(louver_qty / 12);
        $("#linkBar-qty-" + target_item_index).parent().parent("tr").children("td.td-qty").children("input").val(link_bar_qty);
        var link_bar_cost = $("#linkBar-qty-" + target_item_index).parent().parent("tr").children("td.td-item").children("input.price").val();
        var link_bar_price = (link_bar_qty * link_bar_cost);
        $("#linkBar-qty-" + target_item_index).parent().parent("tr").children("td.td-rrp").children("input").val(link_bar_price.toFixed(2));
	} else {
	    var louver_id = $(target_item).parent().parent("tr").children("td.td-item").children("input.price").attr("inventoryid");
	    var louver_qty = $(target_item).parent().parent("tr").children("td.td-qty").children("input").val();
	    var louver_cost = $(target_item).parent().parent("tr").children("td.td-item").children("select").children("option:selected").attr("price");
	    var louver_paint_cost = Number($(target_item).parent().parent("tr").children("td.td-finish-color").children("select").children("option:selected").attr("finishrrp"));
	    var louver_length = get_feet_to_inch($(target_item).parent().parent("tr").children("td.td-ft").children("input:visible").val());
	    var louver_price = (louver_qty * louver_length * louver_cost) + (louver_qty * louver_length * louver_paint_cost);

	    $(target_item).parent().parent("tr").children("td.td-rrp").children("input").val(louver_price.toFixed(2));
	                   
	    var endcap_qty = louver_qty * 2;

	    var pivot_qty = Math.ceil(endcap_qty / 12);
	    $(target_item).parent().parent("tr").next().children("td.td-qty").children("input").val(pivot_qty);
	    var pivot_cost = $(target_item).parent().parent("tr").next().children("td.td-item").children("input.price").val();
	    var pivot_price = (pivot_qty * pivot_cost);
	    $(target_item).parent().parent("tr").next().children("td.td-rrp").children("input").val(pivot_price.toFixed(2));

	    var link_bar_qty = Math.ceil(louver_qty / 12);
	    $(target_item).parent().parent("tr").next().next().children("td.td-qty").children("input").val(link_bar_qty);
	    var link_bar_cost = $(target_item).parent().parent("tr").next().next().children("td.td-item").children("input.price").val();
	    var link_bar_price = (link_bar_qty * link_bar_cost);
	    $(target_item).parent().parent("tr").next().next().children("td.td-rrp").children("input").val(link_bar_price.toFixed(2));
	}

    //update shared endcap field
	louverProcessEndcap();
}
