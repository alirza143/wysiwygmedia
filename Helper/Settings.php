<?php

namespace Magecrafts\WysiwygMedia\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Settings extends AbstractHelper
{
    /**
     * Get extra file types (allowed)
     *
     * @return array|string[]
     */
    public function getExtraFiletypes()
    {
        return [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'pdf',
            'mp4',
            'mov'
        ];
    }

    public static array $mediaFileIcons = [
            'pdf' => ['icon' => 'pdf.png', 'path' => '/adminhtml/web/images/pdf.png'],
            'mp4' => ['icon' => 'mp4.png', 'path' => '/adminhtml/web/images/mp4.png'],
            'mov' => ['icon' => 'mov.png', 'path' => '/adminhtml/web/images/mov.png'],
        ];
    public static array $mediaVideoIcons = [
        'mp4' => ['icon' => 'mp4.png', 'path' => '/adminhtml/web/images/mp4.png'],
        'mov' => ['icon' => 'mov.png', 'path' => '/adminhtml/web/images/mov.png'],
    ];
}
