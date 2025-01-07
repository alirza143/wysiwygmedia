<?php

namespace Magecrafts\WysiwygMedia\Image\Adapter;

use Magecrafts\WysiwygMedia\Helper\Settings;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Psr\Log\LoggerInterface;

class Gd2 extends \Magento\Framework\Image\Adapter\Gd2
{
    /**
     * @var Settings
     */
    protected Settings $settings;

    /**
     * @param Filesystem $filesystem
     * @param LoggerInterface $logger
     * @param Settings $helperSettings
     * @param array $data
     */
    public function __construct(
        Filesystem $filesystem,
        LoggerInterface $logger,
        Settings $helperSettings,
        array $data = []
    ) {
        $this->settings = $helperSettings;
        parent::__construct($filesystem, $logger, $data);
    }

    /**
     * Open image for processing
     *
     * @param string $filename
     * @return void
     * @throws \OverflowException|FileSystemException
     */
    public function open($filename)
    {
        $pathInfo = pathinfo($filename);
        if (!key_exists('extension', $pathInfo)
            || !in_array($pathInfo['extension'], $this->settings->getExtraFiletypes())
        ) {
            parent::open($filename);
        }
    }

    /**
     * Save image to specific path.
     * If some folders of path does not exist they will be created
     *
     * @param null|string $destination
     * @param null|string $newName
     * @return void
     * @throws \Exception  If destination path is not writable
     */
    public function save($destination = null, $newName = null)
    {
        $fileName = $this->_prepareDestination($destination, $newName);
        $pathInfo = pathinfo($fileName);
        if (!key_exists('extension', $pathInfo)
            || !in_array($pathInfo['extension'], $this->settings->getExtraFiletypes())
        ) {
            parent::save($destination, $newName);
        }
    }
}
