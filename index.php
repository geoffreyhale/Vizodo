<?php include 'connect.php'; ?>
<?php include 'header.php'; ?>
<?php include 'postman.php'; ?>



<script language="javascript" type="text/javascript">
<!--
//Browser Support Code
function ajaxNewItemFormFunction(){
  var ajaxRequest;  // The variable that makes Ajax possible!

  try{
    // Opera 8.0+, Firefox, Safari
    ajaxRequest = new XMLHttpRequest();
  } catch (e){
    // Internet Explorer Browsers
    try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try{
        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e){
        // Something went wrong
        alert("Your browser broke!");
        return false;
      }
    }
  }
  // Create a function that will receive data sent from the server
  ajaxRequest.onreadystatechange = function(){
    if(ajaxRequest.readyState == 4){
      var ajaxDisplay = document.getElementById('newItemAjaxFormOutput');
      ajaxDisplay.innerHTML = ajaxRequest.responseText;
    }
  }
  var item = document.getElementById('item').value;
  var queryString = "?item=" + item;
  ajaxRequest.open("GET", "ajax-newItemForm.php" + queryString, true);
  ajaxRequest.send(null);
}

//-->
</script>


<div class="box">
  <form name='newItemAjaxForm'>
    New: <input type='text' id='item' />
    <input type='button' onclick='ajaxNewItemFormFunction()' value='Add' />
  </form>
</div>

<div id='newItemAjaxFormOutput'>(output here)</div>






        <?php app(); ?>





<?php include 'footer.php'; ?>
