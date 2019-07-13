<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Public License
 *
 * @author Novalnet AG <technic@novalnet.de>
 * @copyright Novalnet
 * @license GNU General Public License
 *
 * Script : CreatePaymentMethod_2_0_8.php
 *
 */
 
namespace Novalnet\Migrations;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;
use Novalnet\Helper\PaymentHelper;

/**
 * Migration to create payment mehtods
 *
 * Class CreatePaymentMethod
 *
 * @package Novalnet\Migrations
 */
class UpdatePaymentMethodName
{
    /**
     * @var PaymentMethodRepositoryContract
     */
    private $paymentMethodRepository;

    /**
     * @var PaymentHelper
     */
    private $paymentHelper;

    /**
     * CreatePaymentMethod constructor.
     *
     * @param PaymentMethodRepositoryContract $paymentMethodRepository
     * @param PaymentHelper $paymentHelper
     */
    public function __construct(PaymentMethodRepositoryContract $paymentMethodRepository,
                                PaymentHelper $paymentHelper)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->paymentHelper = $paymentHelper;
    }

    /**
     * Run on plugin build
     *
     * Create Method of Payment ID for Novalnet payment if they don't exist
     */
    public function run()
    {
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_INVOICE', 'Novalnet Invoice');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_PREPAYMENT', 'Novalnet Prepayment');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_CC', 'Novalnet Credit Card');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_SEPA', 'Novalnet Direct Debit SEPA');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_SOFORT', 'Novalnet Online Bank Transfer');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_PAYPAL', 'Novalnet PayPal');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_IDEAL', 'Novalnet iDEAL');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_EPS', 'Novalnet eps');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_GIROPAY', 'Novalnet giropay');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_PRZELEWY', 'Novalnet Przelewy24');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_CASHPAYMENT', 'Novalnet Barzahlen');
    }


    /**
     * Create payment method with given parameters if it doesn't exist
     *
     * @param string $paymentKey
     * @param string $name
     */
    private function createNovalnetPaymentMethodByPaymentKey($paymentKey, $name)
    {
        $payment_data = $this->paymentHelper->getPaymentMethodByKey($paymentKey);
     
        if ($payment_data == 'no_paymentmethod_found')
        {
          $paymentMethodData = ['pluginKey'  => 'plenty_novalnet',
                              'paymentKey' => $paymentKey,
                              'name'       => $name];
            $this->paymentMethodRepository->createPaymentMethod($paymentMethodData);
        } else {
          $paymentMethodData = ['pluginKey'  => 'plenty_novalnet',
                              'paymentKey' => $paymentKey,
                              'name'       => $name,
                               'id'        => $payment_data];
            $this->paymentMethodRepository->updateName($paymentMethodData);
        }
       
    }
}
