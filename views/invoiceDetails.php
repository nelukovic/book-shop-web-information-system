<?php
use app\core\Application;

/** @var $params \app\models\ProductModel
 */

?>

<div class="row">
    <div class="col-md-12">
        <div class="callout callout-info">
            <?php echo sprintf("<h3><b>Invoice number: </b>%s</h3>", $params->id)?>
            <?php echo sprintf("<h3><b>User Created: </b>%s</h3>", $params->idUser)?>
            <?php echo sprintf("<h3><b>Total (€): </b>%s</h3>",$params->total)?>
            <?php echo sprintf("<h3><b>Date Created: </b>%s</h3>", $params->dateCreated)?>
            <?php echo sprintf("<h3><b>Date Updated: </b>%s</h3>", $params->dateUpdated)?>
            <?php echo sprintf("<h3><b>Active: </b>%s</h3>", $params->active ? "Yes" : "No")?>
            <?php echo sprintf("<a href='/invoices' style='text-decoration: none; color: white;' class='btn btn-info'>Go back to list</a>")?>

        </div>
    </div>
</div>
