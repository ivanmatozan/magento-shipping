<?php

declare(strict_types=1);

namespace Matozan\Shipping\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;

class CustomOffline extends AbstractCarrier implements CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'custom_offline';

    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var ResultFactory
     */
    protected $rateResultFactory;

    /**
     * @var MethodFactory
     */
    protected $rateMethodFactory;

    /**
     * CustomOffline constructor.
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        array $data = []
    ) {
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * @inheritDoc
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $result = $this->rateResultFactory->create();
        $method = $this->rateMethodFactory->create();

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));
        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));

        $shippingCost = (float)$this->getConfigData('shipping_cost');
        $method->setPrice($shippingCost);
        $method->setCost($shippingCost);

        $result->append($method);
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getAllowedMethods()
    {
        return ['custom_offline' => $this->getConfigData('name')];
    }
}
