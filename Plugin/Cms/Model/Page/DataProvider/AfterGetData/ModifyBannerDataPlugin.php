<?php
/*
 * @author Magebrew
 * @copyright Copyright (c) 2019 Magebrew
 * @package Magebrew_ImageUploadFormField
 */

declare(strict_types=1);

namespace Magebrew\ImageUploadFormField\Plugin\Cms\Model\Page\DataProvider\AfterGetData;

use Magebrew\ImageUploadFormField\Model\BannerUploader;
use Magento\Cms\Model\Page\DataProvider;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ModifyBannerDataPlugin
 */
class ModifyBannerDataPlugin
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * ModifyBannerDataPlugin constructor.
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @param DataProvider $subject
     * @param $loadedData
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterGetData(
        DataProvider $subject,
        $loadedData
    ) {
        /** @var array $loadedData */
        if (is_array($loadedData)) {
            foreach ($loadedData as $key => $item) {
                if (isset($item['banner_image']) && $item['banner_image']) {
                    $imageArr = [];
                    $imageArr[0]['name'] = 'Image';
                    $imageArr[0]['url'] = $this->storeManager->getStore()
                            ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) .
                        BannerUploader::IMAGE_PATH . DIRECTORY_SEPARATOR . $item['banner_image'];
                    $loadedData[$key]['banner_image'] = $imageArr;
                }
            }
        }

        return $loadedData;
    }
}
