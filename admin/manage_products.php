<?php 
require_once '../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

$products = $db->query("SELECT * from products ORDER BY active DESC")->results();

?>

<div class="row mx-3 my-3">
    <div class="column">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Head 1</th>
                            <th>Status</th>
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
