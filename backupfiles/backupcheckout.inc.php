<?php 
    session_start();
    // session_destroy();
    // This statement is for those customers who have not previously been directed to this page
    if (!isset($_SESSION['checkout'])){
        // This stores address information after button is clicked - so as to send it back and store as billing address if billing-checkbox has been checked
        if (isset($_POST['continue-submit'])){
            if (!isset($_POST['billing-checkbox'])){
                $shipping = array('street1' => $_POST['address-line-one'], 'street2' => $_POST['address-line-two'], 'suburb' => $_POST['suburb'], 'postcode' => $_POST['postcode']);
                
                $contact = array('email' => $_POST['email'], 'phone' => $_POST['phone'], 'first' => $_POST['firstname'], 'last' => $_POST['lastname']);
                
                $_SESSION['checkout']['contact'] = $contact;
                $_SESSION['checkout']['shipping'] = $shipping;

                var_dump($_SESSION['checkout']);
                
                header("Location: ../checkout.php" );
            } else {
                $shipping = array('street1' => $_POST['address-line-one'], 'street2' => $_POST['address-line-two'], 'suburb' => $_POST['suburb'], 'postcode' => $_POST['postcode']);
                
                $contact = array('email' => $_POST['email'], 'phone' => $_POST['phone'], 'first' => $_POST['firstname'], 'last' => $_POST['lastname']);
                
                $billing = array('first' => $_POST['firstname'], 'last' => $_POST['lastname'], 'street1' => $_POST['address-line-one'], 'street2' => $_POST['address-line-two'], 'suburb' => $_POST['suburb'], 'postcode' => $_POST['postcode']);
                
                $_SESSION['checkout']['contact'] = $contact;
                $_SESSION['checkout']['shipping'] = $shipping;
                $_SESSION['checkout']['billing'] = $billing;  
                
                var_dump($_SESSION['checkout']);
                header("Location: ../checkout.php");
            }
        }    
    }
    // deals with recording and resolving checkout - storing information into db
    else {
        include('functions.inc.php');
        $conn = get_connection();
        
        if (isset($_POST['final-submit'])){               
            $billing = array('firstname' => $_POST['firstname-billing'], 'lastname' => $_POST['lastname-billing'],  'street1' => $_POST['address-line-one-billing'], 'street2' => $_POST['address-line-two-billing'], 'suburb' => $_POST['suburb-billing'], 'postcode' => $_POST['postcode-billing']);                    
            
            $creditCard = array('number' => $_POST['card-number'], 'expiry' => $_POST['exp-date'], 'cvv' => $_POST['cvv']);
            
            $_SESSION['checkout']['billing'] = $billing;
            $_SESSION['checkout']['creditcard'] = $creditCard;
            
            // Now have everything needed - connect to database.
            $shipping = $_SESSION['checkout']['shipping'];
            $billing = $_SESSION['checkout']['billing'];
            $contact = $_SESSION['checkout']['contact'];
            $credit = $_SESSION['checkout']['creditcard'];
            
            
            // check if shipping address exists
            $shipping_id = null;
            $contact_id = null;
            $cust_id = null;
            $billing_id = null;
            
            if (isset($_SESSION['id'])){
                $cust_id = $_SESSION['id'];
            }
            
            // Obtain an address id from db
            if ($shipping_id = check_address($conn, $shipping['street1'], $shipping['suburb'], $shipping['postcode'])){
                echo "shipping address already exists...<br>";
            } else {
                if ($shipping_id = add_address($conn, $shipping['street1'], $shipping['street2'], $shipping['suburb'], $shipping['postcode'])){
                    echo "new shipping address successfully processed...<br>";
                } else {
                    echo "shipping address registration failed... <br>";
                }
            }
            
            // obtain a contact id from db
            if ($contact_id = check_contact($conn, $contact['first'], $contact['last'], $contact['email'], $contact['phone'])){
                echo "contact already exists...<br>";
            } else {
                if ($contact_id = add_contact($conn, $contact['first'], $contact['last'], $contact['email'], $contact['phone'], $cust_id)){
                    echo "contact successfully added... <br>";
                } else {
                    echo "contact registration failed... <br>";
                }
            }
            
            // Check if billing and shipping address the same
            if ($shipping['street1'] === $billing['street1'] and $shipping['postcode'] === $billing['postcode']){
                $billing_id = $shipping_id;
                echo "billing id is the same as shipping therefore id is " . $billing_id . "<br>";
            } else {
                if ($billing_id = check_address($conn, $billing['street1'], $billing['suburb'], $billing['postcode'])){
                    echo "billing address exists and successfully processed...<br>";
                } else {
                    if ($billing_id = add_address($conn, $billing['street1'], $billing['street2'], $billing['suburb'], $billing['postcode'])){
                        echo "billing address successfully processed... <br>";
                    } else {
                        echo "problem with billing address...<br>";
                    }
                }
            }
            
            // Store order in db
            
            $items = $_SESSION['cart'];
            $total = 0;
            
            foreach($items as $item){
                $total += $item['quantity'] * floatval($item['price']);
            }
            
            var_dump($total) . "<br>";
            var_dump($credit['number']) . "<br>";
            var_dump($credit['expiry']) . "<br>";
            var_dump(intval($credit['cvv'])) . "<br>";
            var_dump($shipping_id) . "<br>";
            var_dump($billing_id) . "<br>";
            var_dump($cust_id) . "<br>";
            var_dump($contact_id) . "<br>";
            
            if ($order_id = add_order_summary($conn, $total, 7.50, $credit['number'], $credit['expiry'], intval($credit['cvv']), $shipping_id, $billing_id, $cust_id, $contact_id)){
                echo "order has been successfully created...<br>";
            } else {
                echo "there was a problem creating the new order...<br>";
            }
            
            
            
            foreach($items as $item){
                $linePrice = $item['quantity'] * floatval($item['price']);
                echo $linePrice . " ";
                if ($result = add_order_details($conn, $linePrice, $item['quantity'], $item['id'], $order_id)){
                    echo "the order details for " . $item['name'] . " have been processed successfully... <br>";
                } else {
                    echo "the order details for " . $item['name'] . " failed to process... <br>";
                    
                }
            }
            
            header("Location: ../thank-you.php?order='" . $order_id . "'&name='" . $_SESSION['checkout']['contact']['first'] . "'" );
            exit();
            
        } 
        // if the user navigates directly to this page.
        else {
            header("Location: ../checkout.php");
    
        }
    }
    
    
    
    
    // IGNORE BELOW - PROBABLY WON'T NEED
    
    
    
    
    // Attempt to take form data in one take
    // session_start();

    // if (isset($_POST['final-submit'])){
    //     session_start();

    //     if (!isset($_SESSION['checkout'])){
    //         if (!$_POST['billing-checkbox']){
    //             if (empty($_POST['firstname-billing'])){
    //                 header("Location: ../checkout.php");
    //             } else {
    //                 $shipping = array('street1' => $_POST['address-line-one'], 'street2' => $_POST['address-line-two'], 'suburb' => $_POST['suburb'], 'postcode' => $_POST['postcode']);
        
    //                 $billing = array('firstname' => $_POST['firstname-billing'], 'lastname' => $_POST['lastname-billing'],  'street1' => $_POST['address-line-one-billing'], 'street2' => $_POST['address-line-two-billing'], 'suburb' => $_POST['suburb-billing'], 'postcode' => $_POST['postcode-billing']);    
        
    //                 $creditCard = array('creditcard' => $_POST['card-number'], 'expiry' => $_POST['exp-date'], 'cvv' => $_POST['cvv']);
        
    //                 $contact = array('email' => $_POST['email'], 'phone' => $_POST['phone'], 'first' => $_POST['firstname'], 'last' => $_POST['lastname']);
        
    //                 $_SESSION['checkout'] = array('contact' => $contact, 'shipping' => $shipping, 'billing' => $billing, 'creditcard' => $creditCard);
        
    //                 var_dump($_SESSION['checkout']);

    //             }
    //         } else {
    //             if (empty($_POST['firstname-billing'])){
    //                 header("location: ../checkout.php");
    //             }
    //         }
    //     }
    // }
