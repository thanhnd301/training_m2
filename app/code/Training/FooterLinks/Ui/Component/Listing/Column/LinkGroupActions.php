<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 8/31/2016
 * Time: 4:22 PM
 */

namespace Training\FooterLinks\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class LinkGroupActions extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['edit'] = [
                    'href' => $this->urlBuilder->getUrl(
                        'footerlinks/linkgroup/edit',
                        [
                            'id' => $item['group_id']
                        ]
                    ),
                    'label' => __('Edit'),
                    'hidden' => false,
                    'target' => '_blank',
                ];
                $item[$this->getData('name')]['manager'] = [
                    'href' => $this->urlBuilder->getUrl(
                        'footerlinks/link/index',
                        [
                            'linkgroup' => $item['group_id']
                        ]
                    ),
                    'label' => __('Links Manager'),
                    'hidden' => true,
                    'target' => '_blank',
                ];
            }
        }

        return $dataSource;
    }
}