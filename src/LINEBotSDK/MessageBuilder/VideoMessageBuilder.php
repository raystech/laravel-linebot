<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace Raystech\LINEBot\LINEBotSDK\MessageBuilder;

use Raystech\LINEBot\LINEBotSDK\Constant\MessageType;
use Raystech\LINEBot\LINEBotSDK\MessageBuilder;

/**
 * A builder class for video message.
 *
 * @package Raystech\LINEBot\LINEBotSDK\MessageBuilder
 */
class VideoMessageBuilder implements MessageBuilder
{
    /** @var string */
    private $originalContentUrl;
    /** @var string */
    private $previewImageUrl;

    /**
     * VideoMessageBuilder constructor.
     *
     * @param string $originalContentUrl
     * @param string $previewImageUrl
     */
    public function __construct($originalContentUrl, $previewImageUrl)
    {
        $this->originalContentUrl = $originalContentUrl;
        $this->previewImageUrl = $previewImageUrl;
    }

    /**
     * Builds video message structure.
     *
     * @return array
     */
    public function buildMessage()
    {
        return [
            [
                'type' => MessageType::VIDEO,
                'originalContentUrl' => $this->originalContentUrl,
                'previewImageUrl' => $this->previewImageUrl,
            ]
        ];
    }
}
