<?php

namespace Magecrafts\WysiwygMedia\Plugin;

use Magento\MediaGalleryUi\Ui\Component\Control\DeleteAssets;

class ChangeDeleteAssetButtonLabel
{
    /**
     * @param DeleteAssets $subject
     * @param array $buttonData
     * @return array
     */
    public function afterGetButtonData(DeleteAssets $subject, array $buttonData): array
    {
        if (!isset($buttonData['disabled'])){
            $buttonData['label'] = __('Delete');
        }
        return $buttonData;
    }
}
