<?php
namespace Safaricom\Mpesa\Controller\Adminhtml\Mpesa;

use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
	protected $resultPageFactory;

	public function __construct(Context $context,PageFactory $resultPageFactory) 
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}
	
	public function execute()
	{
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu('Safaricom_Mpesa::mpesaadmin');
		$resultPage->addBreadcrumb(__('Reports'), __('Reports'));
		$resultPage->addBreadcrumb(__('Reviews'), __('Reviews'));
		$resultPage->addBreadcrumb(__('Safaricom Mpesa Reports'), __('Safaricom Mpesa Reports'));
		$resultPage->getConfig()->getTitle()->prepend(__('Safaricom Mpesa Reports'));
		return $resultPage;
	}
	
	
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Safaricom_Mpesa::mpesaadmin');
    }
}
