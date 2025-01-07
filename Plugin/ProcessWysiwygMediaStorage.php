<?php

declare(strict_types=1);

namespace Magecrafts\WysiwygMedia\Plugin;

use Magecrafts\WysiwygMedia\Helper\Settings;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Module\Dir\Reader;

class ProcessWysiwygMediaStorage
{
    /**
     * @var Settings
     */
    private Settings $settings;

    /**
     * @var string
     */
    protected $type;
    /**
     * @var Reader
     */
    private Reader $moduleReader;
    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    /**
     * @param Settings $helperSettings
     * @param Reader $moduleReader
     * @param Filesystem $filesystem
     */
    public function __construct(
        Settings $helperSettings,
        Reader $moduleReader,
        Filesystem $filesystem
    ) {
        $this->settings = $helperSettings;
        $this->moduleReader = $moduleReader;
        $this->filesystem = $filesystem;
    }

    /**
     * @param \Magento\Cms\Model\Wysiwyg\Images\Storage $subject
     * @param $type
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeGetAllowedExtensions(
        \Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
                                                  $type
    ) {
        $this->type = $type;
    }

    /**
     * @param \Magento\Cms\Model\Wysiwyg\Images\Storage $subject
     * @param $result
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetAllowedExtensions(
        \Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
                                                  $result
    ) {
        return array_merge($result, $this->settings->getExtraFiletypes());
    }

    /**
     * @param \Magento\Cms\Model\Wysiwyg\Images\Storage $subject
     * @param $source
     * @param $keepRatio
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeResizeFile(
        \Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
                                                  $source,
                                                  $keepRatio = true
    ) {
        $sourceInfo = explode('.', $source);
        $fileExtension = strtolower(end($sourceInfo));
        if (array_key_exists($fileExtension, Settings::$mediaFileIcons)) {
            $source = $this->getMediaPath($fileExtension);
        }
        return [$source, $keepRatio];
    }

    /**
     * @param \Magento\Cms\Model\Wysiwyg\Images\Storage $subject
     * @param \Closure $proceed
     * @param $source
     * @param $keepRatio
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundResizeFile(
        \Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
        \Closure $proceed,
                                                  $source,
                                                  $keepRatio = true
    ) {
        if (array_key_exists(pathinfo($source, PATHINFO_EXTENSION), Settings::$mediaFileIcons)) {
            return $source;
        }

        return $proceed($source, $keepRatio);
    }

    /**
     * @param $fileExtension
     * @return string|void
     */
    public function getMediaPath($fileExtension)
    {
        $fileIcons = Settings::$mediaVideoIcons;

        if (isset($fileIcons[$fileExtension])) {
            $icon = $fileIcons[$fileExtension]['icon'];
            $iconPath = $fileIcons[$fileExtension]['path'];

            $mediaPath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath() . $icon;

            if (!file_exists($mediaPath)) {
                copy(
                    $this->moduleReader->getModuleDir(
                        \Magento\Framework\Module\Dir::MODULE_VIEW_DIR,
                        'Magecrafts_WysiwygMedia'
                    ) . $iconPath,
                    $mediaPath
                );
            }
            return $mediaPath;
        }
    }
}
