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

namespace Modules\ModuleJapaneseLanguagePack\Setup;

use MikoPBX\Core\System\SystemMessages;
use MikoPBX\Modules\PbxExtensionUtils;
use MikoPBX\Modules\Setup\PbxExtensionSetupBase;

/**
 * PbxExtensionSetup
 *
 * Setup class for Japanese Language Pack Module
 *
 * This Language Pack module provides automatic installation of:
 * - Japanese UI translations from Messages/ja/ directory
 * - Japanese voice prompts from sounds/ja-jp/ directory
 *
 * The base class handles all installation/uninstallation automatically:
 * - Sound files are installed via SoundFilesConf::installModuleSounds()
 * - Translations are loaded via MessagesProvider::loadModuleTranslations()
 * - No additional logic is required for Language Pack modules
 *
 * @package Modules\ModuleJapaneseLanguagePack\Setup
 */
class PbxExtensionSetup extends PbxExtensionSetupBase
{
    /**
     * Module unique identifier
     */
    protected string $moduleUniqueID = 'ModuleJapaneseLanguagePack';

    /**
     * Additional actions before module installation
     *
     * For Language Pack modules, we check for conflicts with other Japanese packs.
     * Only one Language Pack per language is allowed.
     *
     * @return bool True if installation can proceed
     */
    public function onBeforeModuleEnable(): bool
    {
        // Check for Language Pack conflicts
        $conflictModule = PbxExtensionUtils::checkLanguagePackConflict(
            $this->moduleUniqueID,
            'ja-jp'
        );

        if ($conflictModule !== null) {
            $this->messages[] = "Cannot install: Another Japanese Language Pack ($conflictModule) is already installed. Please uninstall it first.";
            return false;
        }

        return parent::onBeforeModuleEnable();
    }

    /**
     * Additional actions after module installation
     *
     * @return bool True if successful
     */
    public function onAfterModuleEnable(): bool
    {
        // Log successful installation
        SystemMessages::sysLogMsg(
            __CLASS__,
            'Japanese Language Pack installed successfully (15 translation files, 612 sound files)',
            LOG_INFO
        );

        return parent::onAfterModuleEnable();
    }

    /**
     * Additional actions before module uninstallation
     *
     * @return bool True if uninstallation can proceed
     */
    public function onBeforeModuleDisable(): bool
    {
        // Log uninstallation
        SystemMessages::sysLogMsg(
            __CLASS__,
            'Uninstalling Japanese Language Pack',
            LOG_INFO
        );

        return parent::onBeforeModuleDisable();
    }

    /**
     * Additional actions after module uninstallation
     *
     * @return bool True if successful
     */
    public function onAfterModuleDisable(): bool
    {
        // Log successful uninstallation
        SystemMessages::sysLogMsg(
            __CLASS__,
            'Japanese Language Pack uninstalled successfully',
            LOG_INFO
        );

        return parent::onAfterModuleDisable();
    }
}
