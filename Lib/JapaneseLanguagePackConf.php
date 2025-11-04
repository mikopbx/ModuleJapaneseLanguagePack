<?php
/*
 * MikoPBX - free phone system for small business
 * Copyright © 2017-2025 Alexey Portnov and Nikolay Beketov
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <https://www.gnu.org/licenses/>.
 */

namespace Modules\ModuleJapaneseLanguagePack;

use MikoPBX\Modules\Config\ConfigClass;

/**
 * ModuleJapaneseLanguagePackConf
 *
 * Japanese Language Pack Module for MikoPBX
 *
 * This is a Language Pack module that provides:
 * - Complete Japanese UI translations (15 files in Messages/ja/)
 * - Japanese voice prompts (612 sound files in sounds/ja-jp/)
 *
 * Language Pack modules are installed automatically without additional configuration.
 * Sound files and translations are managed by the core system.
 *
 * @package Modules\ModuleJapaneseLanguagePack
 */
class ModuleJapaneseLanguagePackConf extends ConfigClass
{
    /**
     * Module unique identifier
     */
    public const string MODULE_ID = 'ModuleJapaneseLanguagePack';

    /**
     * Language code for this pack
     */
    public const string LANGUAGE_CODE = 'ja-jp';

    /**
     * Returns module description for the admin interface
     *
     * @return array Module description
     */
    public function getModuleDescription(): array
    {
        return [
            'name' => 'Japanese Language Pack',
            'description' => 'Complete Japanese language support including UI translations and voice prompts',
            'developer' => 'MikoPBX',
            'version' => '1.0.0',
            'language_code' => self::LANGUAGE_CODE,
            'module_type' => 'languagepack'
        ];
    }
}
