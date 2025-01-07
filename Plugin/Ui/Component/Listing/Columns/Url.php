<?php

namespace Magecrafts\WysiwygMedia\Plugin\Ui\Component\Listing\Columns;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;
use Magecrafts\WysiwygMedia\Helper\Settings;

class Url
{

    /**
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param Settings $helperSettings
     */
    public function __construct(
        public Filesystem $filesystem,
        public StoreManagerInterface $storeManager,
        public Settings $helperSettings
    ) {}

    /**
     * @param \Magento\MediaGalleryUi\Ui\Component\Listing\Columns\Url $subject
     * @param $result
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws NoSuchEntityException
     */
    public function afterPrepareDataSource(
        \Magento\MediaGalleryUi\Ui\Component\Listing\Columns\Url $subject,
                                                                 $result
    )
    {
        $media_url = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        foreach ($result['data']['items'] as &$item) {
            $contentType = strtolower($item['content_type']);
            if (isset(Settings::$mediaFileIcons[$contentType])) {
                $item['thumbnail_url'] = $media_url . Settings::$mediaFileIcons[$contentType]['icon'];
            }
        }
        return $result;
    }
}
