<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/12/2016
 * Time: 10:06 AM
 */

namespace Training\FooterLinks\Ui\DataProvider\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Training\FooterLinks\Model\ResourceModel\LinkGroup\CollectionFactory as GroupCollectionFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\App\ObjectManager;

class GroupDataProvider extends AbstractDataProvider
{
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var SessionManagerInterface
     */
    protected $session;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $groupCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        GroupCollectionFactory $groupCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $groupCollectionFactory->create();
    }

    /**
     * Get session object
     *
     * @return SessionManagerInterface
     */
    protected function getSession()
    {
        if ($this->session === null) {
            $this->session = ObjectManager::getInstance()->get('Magento\Framework\Session\SessionManagerInterface');
        }
        return $this->session;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        /** @var $group \Training\FooterLinks\Model\Group */
        foreach ($items as $group) {
            $this->loadedData[$group->getId()] = ['general'=>$group->getData()];
        }

        $data = $this->getSession()->getFormData();
        if (!empty($data)) {
            $groupId = isset($data['general']['group_id']) ? $data['general']['group_id'] : null;
            $this->loadedData[$groupId] = $data;
            $this->getSession()->unsFormData();
        }

        return $this->loadedData;
    }
}