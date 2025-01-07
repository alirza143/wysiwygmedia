<?php

namespace Magecrafts\WysiwygMedia\Plugin;

use Magento\MediaGalleryUi\Ui\Component\Control\UploadAssets;

class ChangeUploadAssetButtonLabel
{
    /**
     * @param UploadAssets $subject
     * @param array $buttonData
     * @return array
     */
    public function afterGetButtonData(UploadAssets $subject, array $buttonData): array
    {
        if (!isset($buttonData['disabled'])){
            $buttonData['label'] = __('Upload');
        }
        return $buttonData;
    }
}
