<?php

require '../../config.php';

use App\Classes\Paypal\SimulateWebhook;
use PayPal\Api\WebhookEvent;
use App\Classes\Paypal\Events;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $bodyReceived = file_get_contents('php://input');

  // ### Validate Received Event Method
  // Call the validateReceivedEvent() method with provided body, and apiContext object to validate
  try {
      /** @var \PayPal\Api\WebhookEvent $output */
      $output = WebhookEvent::validateAndGetReceivedEvent($bodyReceived, $api->api);

      $data = json_decode($output);

      $event = new Events;
      $event->verifyEvent($data);

      // $output would be of type WebhookEvent
      // $data = $output->toArray();
      // if($data['status'] == 'INVOICING.INVOICE.CANCELLED'){

      // }

      // if($data['status'] == 'PAYMENT.SALE.COMPLETED'){
      //   $id = $data['resource']['parent_payment'];
      //   $total = $data['resource']['amount']['total'];
      // }


  } catch (\InvalidArgumentException $ex) {
      // This catch is based on the bug fix required for proper validation for PHP. Please read the note below for more details.
      // If you receive an InvalidArgumentException, please return back with HTTP 503, to resend the webhooks. Returning HTTP Status code [is shown here](http://php.net/manual/en/function.http-response-code.php). However, for most application, the below code should work just fine.
      http_response_code(503);
  } catch (Exception $ex) {
      echo $ex->getMessage();
      exit(1);
}
}
    // $data = [
    //     'webhook_id' => '0A454512479398328',
    //     'event_type' => 'PAYMENT.SALE.COMPLETED'
    // ];

    // $simulate = new SimulateWebhook();
    // $retornoWebhook = $simulate->simulate($data);
    // dump($retornoWebhook);

