<?php

namespace Magecrafts\WysiwygMedia\Plugin;

use Magecrafts\WysiwygMedia\Helper\Settings;
use Magento\Cms\Helper\Wysiwyg\Images;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManager;
use Magento\Framework\Escaper;

class AddVideoTagWysiwyg
{
    /**
     * @var Escaper
     */
    private Escaper $escaper;

    /**
     * @var StoreManager
     */
    private StoreManager $storeManager;

    /**
     * @param StoreManager $storeManager
     * @param Escaper $escaper
     */
    public function __construct(
        StoreManager $storeManager,
        Escaper $escaper
    ) {
        $this->escaper = $escaper;
        $this->storeManager = $storeManager;
    }

    /**
     * @param Images $subject
     * @param string $result
     * @param string $filename
     * @param bool $renderAsTag
     * @return string
     * @throws NoSuchEntityException
     */
    public function afterGetImageHtmlDeclaration(Images $subject, string $result, $filename, $renderAsTag = false): string
    {
        $fileUrl = $subject->getCurrentUrl() . $filename;
        $mediaUrl = $this->storeManager->getStore($this->storeManager->getStore()->getId())->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $mediaPath = str_replace($mediaUrl, '', $fileUrl);
        $directive = sprintf('{{media url="%s"}}', $mediaPath);
        $src = $subject->isUsingStaticUrlsAllowed() ? $fileUrl : $this->escaper->escapeHtml($directive);
        if (array_key_exists(pathinfo($mediaPath, PATHINFO_EXTENSION),Settings::$mediaVideoIcons)) {
            $result = sprintf('<video controls preload="metadata"><source src="%s" type="video/mp4"></video>', $src);
        }
        return $result;
    }
}
