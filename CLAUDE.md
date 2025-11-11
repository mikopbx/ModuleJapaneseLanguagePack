# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Language Pack module for MikoPBX that provides Japanese localization:
- 15 translation files in `Messages/ja/` (PHP arrays with Japanese UI strings)
- 612 voice prompt files in `Sounds/ja-jp/` (GSM audio files)
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
- Enable: `SoundFilesConf::installModuleSounds()` copies files to system
- Disable: `SoundFilesConf::removeModuleSounds()` removes files + language fallback

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

## Important Notes

- Language Packs have no database migrations or custom logic by design
- Sound files are GSM format (Asterisk standard)
- Only one Language Pack per language can be active (enforced by `PbxExtensionUtils::checkLanguagePackConflict()`)
- When disabled, system automatically falls back to en-en if ja-jp was active
- Translation files must match MikoPBX core structure for automatic loading
