<?php
// for a more in-depth script and discussion please visit the source at 
// https://www.fontis.com.au/blog/resending-magento-order-emails

// CONFIGURATION
$orderbegin = 10005000
$orderend = 10005050

define("MAGE_BASE_DIR", "/www/");
require_once MAGE_BASE_DIR . '/app/Mage.php';
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$orderIncrements = range($orderbegin, $orderen);
$count = 0;
foreach ($orderIncrements as $orderIncrement) {
    // try every number, if there is no order for that number (it's been cancelled or otherwise not completed),
    // it will skip it
    $order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrement);
    if ($order->getId()) {
        try {
            $order->sendNewOrderEmail();
            echo "Order $orderIncrement successfully sent\n";
            $count += 1;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    // Modify as per your environments handling of emails. If it can handle emails going out quicker, do it!
    sleep(2);
}
echo ("sent " . $count . " emails");
