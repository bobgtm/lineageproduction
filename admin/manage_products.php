<?php 
require_once '../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

$products = $db->query("SELECT * from products ORDER BY active DESC")->results();
if(!empty($_POST['addProduct'])) {
    $name = Input::get('newProduct');
    $ptype = Input::get("prodType");
    
    $fields = [
        'product_name' => $name,
        'product_type' => $ptype,
        'active' => 1,
    ];
    
    
    if($ptype == 1){
        $db->insert('products', $fields);
        $newProdId = $db->lastId();
        $fields2 = [
            'coffee_name' => $name,
            'active' => 1,
            'product_id' => $newProdId,
        ];
        $db->insert('products_coffee', $fields2);
        Redirect::to("manage_products.php");
    } 
    if($ptype == 2 || $ptype == 3 || $ptype == 4) {
        $db->insert('products', $fields);
        Redirect::to("manage_products.php");
    } 
    
    
}


?>
<div class="row mx-3 my-3">

    <div class="column">
        <div class="card">
            <div class="card-header">Add Product</div>
            <div class="card-body">
                <form action="" method="post" class="">
                    <div class="d-flex justify-content-between flex-row">
                        <div class="flex-grow-1 mx-2">
                            <label for="newProduct"  class="mb-2">Name</label>
                            <input class="form-control mb-2" type="text" name="newProduct">
                        </div>
                        <div class="flex-grow-1 mx-2">
                            <label for="newProduct" class="mb-2">Product Type</label>
                            <select name="prodType" class="form-control mb-2" id="">
                                <option value="">Select...</option>
                                <option value="1">Coffee</option>
                                <option value="2">Cold Brew</option>
                                <option value="3">Syrup</option>
                                <option value="4">Pastry</option>
                            </select>
                        </div>
                    </div>
                    
                    <input type="submit" name="addProduct" value="Save" class="btn btn-primary flex-grow-0 mx-2">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row mx-3 my-3">
    <div class="column">
        <div class="card">
            <div class="card-header">
                Manage Product Status
            </div>
            <div class="card-body">

                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Toggle Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $p) { ?>
                        <tr>
                            <td><?= $p->product_name ?></td>
                            
                            <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input switch" type="checkbox" role="switch" id="<?= $p->id ?>" <?= $p->active == 1 ? "checked" : "";?>/>
                                <label class="form-check-label" for="<?= $p->id ?>" id="<?= $p->id ?>" data-update="update"><?= $p->active < 1 ? "Disabled" : "Enabled";?></label>
                            </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            
            </div>
        </div>
        
    </div>
</div>
<script>
    $(document).ready(function() {

        var label = $('.form-check-label').attr('data-update')
        // console.log(label)
        $('.form-check-input.switch').on('change', function() {
        


            var checkbox = $(this);
            var id = checkbox.attr('id')
            var checked = checkbox.prop('checked') ? 1 : 0;
            var label = checkbox.closest('label').find('.form-check-label');
   
           var nid = Number(id)
            var formData = {
                'id': nid,
                'active': checked
            }
            
            $.ajax({
                method: 'POST',
                url: "../includes/parsers/product_status.php",
                data: formData,
                dataType: 'json',
            }).done(function(responseData) {
                console.log(responseData); // You can directly work with responseData as an object
                $("label[for='" + nid + "']").html(responseData.status);
                
            })
        });
    });
</script>
