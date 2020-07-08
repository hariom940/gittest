<?php
require_once("dbcon.php");
$sql = "SELECT  * FROM countries";
$result = $conn->query($sql);
    $countries = [];
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $countries[] = [
            'id' => $row['id'],
            'sortname' => $row['sortname'],
            'name' => $row['name'],
        ];
    }
} 

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">    
        <title>Painting Competition By Alliance Club International, a Worldwide Social Organisation</title>      
        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <link href="assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="assets/css/hover-min.css" rel="stylesheet">
        <link href="assets/css/animate.css" rel="stylesheet">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
    </head>
<body>
<div class="col-lg-6 col-md-6 col-sm-12">
<div class="form-group">
<div class="form-control-select">
<select placeholder="" class="form-control change-country" name="country" required>
    <option selected="" value="">Country</option>
    <?php
        foreach ($countries as $key => $value) {
    ?>
        <option value="<?php echo $value['id']; ?>"> <?php echo $value['name']; ?></option>
  <?php  
      }
    ?>
   
</select>

</div>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12">
<div class="form-group">
<div class="form-control-select">
<select placeholder="" class="form-control" name="state" id="state" required>
    <option value="">State</option>
</select>
</div>
</div>
</div>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script>
        (function(){
            let TempVar = {
                data:{
                    country_id : ''
                },
            init(){
                this.selectOnchange();
            },
            selectOnchange(){
                $('.change-country').on('change',function(){
                    this.ajaxurl = "http://localhost/state/findState.php";
                    this.method  = "GET";
                    this.data = {
                    country_id  : this.value
                    };
                    //TempVar.data.country_id = jQuery(this).val();
                    TempVar.ajaxCall( this.ajaxurl, this.method, this.data, "state" );
                });
            },
            callback($res, $callback){
                if($callback==='state'){
                    var res = JSON.parse($res);
                   
                    if(typeof(res) === "object" && res.length >1){
                    //    alert(res);
                        var html ='<option value="">Select state</option>';
                    res.map(($value, $index)=>{ 
                        html +=`<option value="${$value.id}" >${$value.name}</option>`;
                    });
                    $('#state').html(html);
                }
                // console.log($res);
                }
            },
            ajaxCall( $ajaxurl, $method, $data, $callback){
                jQuery.ajax({
                url: $ajaxurl,
                method: $method,
                data: $data,
                cache: false,
            }).done((res)=>{
                TempVar.callback(res, $callback);
            }).fail((jqXhr, textError, msg) =>{
                console.error(textError+": "+msg);
            })
            },
            run(){
                let self = this;
                self.init();
            }
            };
            jQuery(document).ready(function(){
                TempVar.run();
            })
        })(window,document);
        </script>
 
</body>
</html>