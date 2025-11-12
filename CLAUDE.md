# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Language Pack module for MikoPBX that provides Japanese localization:
- 15 translation files in `Messages/ja/` (PHP arrays with Japanese UI strings)
- 608 voice prompt files in `Sounds/ja-jp/` (WAV audio files from official Asterisk core-sounds-ja-1.6.1)
- Module type: `languagepack` with language code `ja-jp`
- Minimum MikoPBX version: 2025.1.1

## Architecture

### Module Structure
- **Setup/PbxExtensionSetup.php** - Installation/uninstallation hooks
  - Checks for Language Pack conflicts (only one Japanese pack allowed)
  - Logs installation/uninstallation events

- **Lib/JapaneseLanguagePackConf.php** - Core module configuration (extends ConfigClass)
  - `onAfterModuleEnable()` - Installs sound files via `SoundFilesConf::installModuleSounds()`
  - `onAfterModuleDisable()` - Removes sound files and switches to en-en if ja-jp was active

- **App/Controllers/ModuleJapaneseLanguagePackController.php** - Information page controller
  - `indexAction()` - Displays module info with file counts
  - View path: `Modules/ModuleJapaneseLanguagePack/ModuleJapaneseLanguagePack/index`

### Key Concepts

**Language Pack Modules**: Special MikoPBX modules that provide:
1. UI translations loaded automatically from `Messages/{lang}/` by MessagesProvider
2. Voice prompts installed from `Sounds/{lang-code}/` directory
3. No additional logic needed - base classes handle everything

**Sound File Management**:
- Enable: `SoundFilesConf::installModuleSounds()` copies files to system (replaces existing)
- Disable: `SoundFilesConf::removeModuleSounds()` removes entire language directory, then attempts to restore original system sounds from `/offload/asterisk/sounds/{lang}/` if they exist
- Philosophy: Language Packs are **full replacements** of the language, not extensions

**Translation Files**: PHP arrays in `Messages/ja/` mirroring MikoPBX core structure:
- Common.php, Extensions.php, GeneralSettings.php, etc.
- Each returns array with 'English Key' => '日本語訳' mappings

## Development Commands

### Code Quality
```bash
# Run PHPStan for code quality checks (as per global CLAUDE.md)
phpstan analyze
```

### Testing Module Installation
```bash
# Module installation happens via MikoPBX UI:
# System → Extension Modules → Marketplace → Install
# Or test locally by placing in MikoPBX's modules directory
```

### Building (if needed)
```bash
# Check .github/workflows/build.yml for CI/CD build process
```

## Module Configuration

**module.json** defines:
- `module_type: "languagepack"` - Identifies as language pack
- `language_code: "ja-jp"` - Language identifier
- `min_pbx_version: "2025.1.1"` - Minimum compatible version
- Release settings for GitHub releases and changelog
- **Translation sync settings** (new):
  - `translation_sync.enabled` - Enable/disable automatic translation sync from Core
  - `translation_sync.source_repo` - Source repository (e.g., "mikopbx/Core")
  - `translation_sync.source_branch` - Branch to sync from (e.g., "develop")
  - `translation_sync.language_code` - Language code in source repo (e.g., "ja")
  - `translation_sync.exclude_files` - Files to preserve (e.g., ["ModuleJapaneseLanguagePack.php"])

## Important Notes

- Language Packs have no database migrations or custom logic by design
- Sound files are WAV format (high quality, auto-converted to multiple formats by WorkerSoundFilesInit)
- Only one Language Pack per language can be active (enforced by `PbxExtensionUtils::checkLanguagePackConflict()`)
- When disabled, system automatically falls back to en-en if ja-jp was active
- Translation files must match MikoPBX core structure for automatic loading

### Sound File Removal and Restoration Behavior

When a Language Pack module is **disabled**:
1. The entire language directory (`/mountpoint/mikopbx/media/sounds/ja-jp/`) is removed
2. System checks if original sounds exist in `/offload/asterisk/sounds/ja-jp/`
3. If found, original system sounds are restored automatically
4. If not found (normal for new languages not in Docker image), directory remains empty
5. WorkerSoundFilesInit handles format conversion for restored files automatically

This ensures:
- Users get back original system sounds when disabling custom Language Packs
- No data loss for languages shipped with MikoPBX
- Clean removal for truly new languages (e.g., custom Language Packs for unsupported languages)

### Translation Sync During Build

When building Language Pack modules in GitHub Actions:
1. If `translation_sync.enabled` is `true` in `module.json`, the build process automatically syncs translations
2. Files are fetched from the specified `source_repo` and `source_branch` (e.g., mikopbx/Core@develop)
3. All PHP files from `src/Common/Messages/{language_code}/` are copied to module's `Messages/{language_code}/`
4. Files in `exclude_files` array are preserved (e.g., `ModuleJapaneseLanguagePack.php`)
5. This ensures Language Packs always contain the latest Weblate translations from Core

**Benefits:**
- Language Packs automatically get updated translations without manual copying
- Weblate changes in mikopbx/Core are propagated to Language Pack releases
- Module-specific translation files can be preserved via `exclude_files`
