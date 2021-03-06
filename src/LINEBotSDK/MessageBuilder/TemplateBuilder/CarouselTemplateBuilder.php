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

namespace Raystech\LINEBot\LINEBotSDK\MessageBuilder\TemplateBuilder;

use Raystech\LINEBot\LINEBotSDK\Constant\TemplateType;
use Raystech\LINEBot\LINEBotSDK\MessageBuilder\TemplateBuilder;

/**
 * A builder class for carousel template.
 *
 * @package Raystech\LINEBot\LINEBotSDK\MessageBuilder\TemplateBuilder
 */
class CarouselTemplateBuilder implements TemplateBuilder
{
    /** @var CarouselColumnTemplateBuilder[] */
    private $columnTemplateBuilders;

    /** @var array */
    private $template;

    /**
     * CarouselTemplateBuilder constructor.
     *
     * @param CarouselColumnTemplateBuilder[] $columnTemplateBuilders
     */
    public function __construct(array $columnTemplateBuilders)
    {
        $this->columnTemplateBuilders = $columnTemplateBuilders;
    }

    /**
     * Builds carousel template structure.
     *
     * @return array
     */
    public function buildTemplate()
    {
        if (!empty($this->template)) {
            return $this->template;
        }

        $columns = [];
        foreach ($this->columnTemplateBuilders as $columnTemplateBuilder) {
            $columns[] = $columnTemplateBuilder->buildTemplate();
        }

        $this->template = [
            'type' => TemplateType::CAROUSEL,
            'columns' => $columns,
        ];

        return $this->template;
    }
}
