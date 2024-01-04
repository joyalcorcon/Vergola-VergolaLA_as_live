<?php  
if(isset($_POST['add']))
{ 
  $Marketing_Source_add=$_POST['marketing_source'] ;
  $Lead_add=$_POST['lead'] ;
  // $Marketing_Source_add = "Test";
        


  mysql_query("INSERT INTO ver_chronoforms_data_lead_vic (marketing_source,lead) 
     VALUES ('$Marketing_Source_add','$Lead_add')");
      
  
  
  header('Location:'.JURI::base().'system-management-vic/lead-listing-vic');    
}

//if(isset($_POST['cancel']))
//{ 
//  header('Location:'.JURI::base().'system-management-vic/lead-listing-vic');  
//}

$cbo_marketing_source = "<select name=\"marketing_source\" style='width:100%; padding:0px'><option value=''>Select Marketing Source</option>"; 
$querysub="SELECT * FROM ver_chronoforms_data_lead_vic WHERE marketing_source != '' GROUP BY marketing_source ORDER BY marketing_source ASC";
      $resultsub = mysql_query($querysub);
        if(!$resultsub){die ("Could not query the database: <br />" . mysql_error()); }            
      while ($data=mysql_fetch_assoc($resultsub)){  
        // $cbo_marketing_source .= "<option value = \"".addslashes($data['marketing_source'])."\">{$data['marketing_source']}</option>";
        $cbo_marketing_source .= "<option value = \"".addslashes($data['marketing_source'])."\" selected>{$data['marketing_source']}</option>";
        // if($data['marketing_source']==$contract_vergola['marketing_source']){ 
        //   $cbo_marketing_source .= "<option value = \"".addslashes($data['marketing_source'])."\" selected>{$data['marketing_source']}</option>";
        // }else{
        //   $cbo_marketing_source .= "<option value = \"".addslashes($data['marketing_source'])."\">{$data['marketing_source']}</option>";
        // } 
      }
$cbo_marketing_source .= "</select>"; 
?>

<form class="Chronoform hasValidation" method="post" id="chronoform_Lead_Vic" action="<?php echo JURI::base(); ?>system-management-vic/lead-listing-vic/lead-vic">
<table class="update-table" style="width: 50%;">
   
  <tr>
    <td class="row1" >Marketing Source :</td>
    <td class="" style="width: 20%;"><?php echo $cbo_marketing_source; ?></td>
    <td class="row1" style="width: 12%;">Lead Source :</td>
    <td class="" ><input style="width: 100%;" type="text" name="lead" value="<?php echo $Lead_add ?>"/></td>
  </tr>
  <tr>
    <td class="row1">&nbsp;</td>
    <td class="">&nbsp;</td>
    <td class="">&nbsp;</td>
    <td class="row2"><input type="submit" name="add" value="Save" class="update-btn" /> <input type="button" name="cancel" value="Cancel" class="update-btn" onclick=location.href='<?php echo JURI::base(); ?>system-management-vic/lead-listing-vic' /></td>
  </tr>
</table>

</form>