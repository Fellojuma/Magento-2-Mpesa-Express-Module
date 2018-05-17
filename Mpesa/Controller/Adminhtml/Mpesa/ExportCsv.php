<?php

namespace Safaricom\Mpesa\Controller\Adminhtml\Mpesa;

class ExportCsv extends \Magento\Backend\App\Action
{
	public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->_registry = $registry;
        $this->_fileFactory = $fileFactory;
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_resultRedirectFactory = $resultRedirectFactory;
    }
	
    public function execute()
    {
        $this->_view->loadLayout();
        $fileName = 'safaricom.csv';
        $content = $this->_view->getLayout()->getBlock('mpesaadmin.mpesa.grid');

        return $this->_fileFactory->create(
            $fileName,
            $content->getCsvFile($fileName),
            \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR
        );
    }
}
