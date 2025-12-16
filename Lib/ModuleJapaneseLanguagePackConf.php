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

use MikoPBX\Common\Models\PbxSettings;
use MikoPBX\Core\System\Configs\SoundFilesConf;
use MikoPBX\Core\System\SystemMessages;
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
 * Language Pack modules manage sound files on enable/disable:
 * - Enable: Install sound files to system
 * - Disable: Remove sound files and fallback to English if needed
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
     * Called when module is enabled
     * Installs Japanese sound files to the system
     *
     * @return void
     */
    public function onAfterModuleEnable(): void
    {
        SystemMessages::sysLogMsg(
            __METHOD__,
            'Japanese Language Pack enabled, installing sound files',
            LOG_INFO
        );

        // Install sound files (612 files)
        $result = SoundFilesConf::installModuleSounds(self::MODULE_ID);

        if ($result) {
            SystemMessages::sysLogMsg(
                __METHOD__,
                'Japanese sound files installed successfully',
                LOG_INFO
            );
        } else {
            SystemMessages::sysLogMsg(
                __METHOD__,
                'Failed to install Japanese sound files',
                LOG_WARNING
            );
        }
    }

    /**
     * Called when module is disabled
     * Removes Japanese sound files and switches to English if Japanese was active
     *
     * @return void
     */
    public function onAfterModuleDisable(): void
    {
        SystemMessages::sysLogMsg(
            __METHOD__,
            'Japanese Language Pack disabled, removing sound files',
            LOG_INFO
        );

        // Check if Japanese language is currently active
        $currentLanguage = PbxSettings::getValueByKey(PbxSettings::PBX_LANGUAGE);

        if ($currentLanguage === self::LANGUAGE_CODE) {
            // Switch to English as fallback
            $languageSetting = PbxSettings::findFirstByKey(PbxSettings::PBX_LANGUAGE);
            if ($languageSetting !== null) {
                $languageSetting->value = 'en-en';
                $languageSetting->save();

                SystemMessages::sysLogMsg(
                    __METHOD__,
                    'System language switched from ja-jp to en-en (fallback)',
                    LOG_NOTICE
                );
            }
        }

        // Remove sound files (entire ja-jp directory)
        $result = SoundFilesConf::removeModuleSounds(self::MODULE_ID);

        if ($result) {
            SystemMessages::sysLogMsg(
                __METHOD__,
                'Japanese sound files removed successfully',
                LOG_INFO
            );
        } else {
            SystemMessages::sysLogMsg(
                __METHOD__,
                'Failed to remove Japanese sound files',
                LOG_WARNING
            );
        }
    }
}
