<?php


namespace app\models;

use app\core\DBModel;
use app\core\Model;

class InvoiceModel extends DBModel
{
    public $id;
    public $dateCreated;
    public $dateUpdated;
    public $idUser;
    public $active;
    public $total;

    public function rules(): array
    {
        return [
        ];
    }

    public function tableName()
    {
        return 'invoices';
    }

    public function labels(): array
    {
        return [
            "id" => "Id",
            "idUser" => "Id User",
            "total" => "Total",
            "active" => "Active"
        ];
    }

    public function invoicesLoadMore($numberOfPage, $numberOfRows, $search)
    {
        $db = $this->dbConnection->conn();

        if ($search !== null and $search !== "") {
            $sqlString = "
                select  inv.id, 
                        inv.dateCreated, 
                        inv.dateUpdated,
                        inv.total,
                        u.firstName, 
                        u.lastName, 
                        inv.active
                from invoices inv
                inner join users u on inv.idUser = u.id
                where u.firstName and u.lastName like '%$search%' or inv.id like '%$search%' LIMIT $numberOfRows";
        } else {
            $startOn = $numberOfPage * $numberOfRows;
            $sqlString = "
                select  inv.id, 
                        inv.dateCreated, 
                        inv.dateUpdated,
                        inv.total,
                        u.firstName, 
                        u.lastName, 
                        inv.active
                from invoices inv
                inner join users u on inv.idUser = u.id
                where u.firstName and u.lastName like '%$search%' or inv.id like '%$search%' LIMIT $startOn, $numberOfRows";
        }

        $dbData = $db->query($sqlString) or die($db->error);

        $resultArray = [];

        while ($result = $dbData->fetch_assoc()) {
            array_push($resultArray, $result);
        }

        return $resultArray;
    }

    public function createMultipleInvoiceItem($products, $quantity, $invoiceId)
    {
        $db = $this->dbConnection->conn();
        $currentDate = date('Y-m-d');
        $active = true;

        $sqlString = "INSERT INTO invoice_items (`dateCreated`, `dateUpdated`, `idProduct`, `quantity`, `idInvoice`, `active`) VALUES ";

        for ($i = 0; $i < count($products); ++$i) {
            if (isset($products[$i]) and $products[$i] !== 0 and $products[$i] !== null and $products[$i] !== "" and $products[$i] !== "0" and $quantity[$i] !== ''){
                $sqlString = $sqlString . "('$currentDate', '$currentDate', '$products[$i]', '$quantity[$i]', '$invoiceId', '$active'),";
            }
        }

        $sqlString = substr_replace($sqlString, ";", -1);

        $db->query($sqlString) or die();

        return true;
    }

    public function createInvoice($userId, $customerId, $products, $quantity)
    {
        $db = $this->dbConnection->conn();
        $currentDate = date('Y-m-d');
        $active = true;
        $total = 0;
        $productModel = new ProductModel();

        for ($i = 0; $i < count($products); ++$i) {
            if (isset($products[$i]) and $products[$i] !== 0 and $products[$i] !== null and $products[$i] !== "" and $products[$i] !== "0" and $quantity[$i] !== ''){
                $productModel->loadData($productModel->one("id= $products[$i]"));

                $total = $total + ($productModel->price * $quantity[$i]);
            }
        }

        $sqlString = "INSERT INTO invoices (`dateCreated`, `dateUpdated`, `idUser`, `idCustomer`, `total`, `active`) VALUES ('$currentDate', '$currentDate', '$userId', '$customerId', '$total', '$active')";

        $db->query($sqlString) or die();

        return true;
    }

    public function lastAddedInvoice(){
        $db = $this->dbConnection->conn();

        $sqlString = "SELECT id FROM invoices ORDER BY id DESC LIMIT 1";

        $dbData = $db->query($sqlString) or die();

        $lastAddedInvoice = $dbData->fetch_assoc();

        return intval($lastAddedInvoice['id']);
    }

    public function createFullInvoice($userId, $customerId, $products, $quantity)
    {
        if (!$this->createInvoice($userId, $customerId, $products, $quantity))
            return false;

        $invoiceId = $this->lastAddedInvoice();

        $result = $this->createMultipleInvoiceItem($products, $quantity, $invoiceId);

        return $result;
    }

    public function attributes(): array
    {

    }

    public function invoiceActive()
    {
        $db = $this->dbConnection->conn();

        $sqlString = "select case when `active` = 1 then 'Aktivan' else 'Neaktivan' end as 'active', count(id) as 'numberOfInvoices' from invoices group by `active`";

        $dataResult = $db->query($sqlString) or die();

        $resultArray = [];

        while ($result = $dataResult->fetch_assoc()) {
            array_push($resultArray, $result);
        }

        return $resultArray;
    }
}