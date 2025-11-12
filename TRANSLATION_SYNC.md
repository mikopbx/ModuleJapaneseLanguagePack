# Translation Sync Feature

This module uses automatic translation synchronization from MikoPBX Core during GitHub Actions builds.

## Overview

When building releases on GitHub, the workflow automatically pulls the latest translation files from `mikopbx/Core` repository. This ensures that:
- Language Packs always contain the latest Weblate translations
- Manual copying of translation files is not needed
- Updates from Weblate are automatically included in new releases

## Configuration

Translation sync is configured in `module.json`:

```json
{
  "translation_sync": {
    "enabled": true,
    "source_repo": "mikopbx/Core",
    "source_branch": "develop",
    "language_code": "ja",
    "exclude_files": ["ModuleJapaneseLanguagePack.php"]
  }
}
```

### Settings Explained

- **enabled**: Set to `false` to disable translation sync
- **source_repo**: Always "mikopbx/Core" for standard Language Packs
- **source_branch**:
  - Use `"develop"` for latest translations (recommended for development)
  - Use `"master"` for stable translations (recommended for production releases)
- **language_code**: Short language code used in Core (e.g., "ja", "ru", "de")
- **exclude_files**: Module-specific files to preserve (e.g., `ModuleJapaneseLanguagePack.php`)

## How It Works

### During GitHub Actions Build

1. **Checkout**: The workflow checks out both the module and Core repositories
2. **Sync**: Translation files are copied from Core's `src/Common/Messages/{language_code}/` to module's `Messages/{language_code}/`
3. **Preserve**: Files in `exclude_files` are not overwritten
4. **Package**: The updated module is packaged with fresh translations

### What Gets Synced

All PHP translation files from Core:
- ✅ `Common.php`
- ✅ `Extensions.php`
- ✅ `GeneralSettings.php`
- ✅ `MailSettings.php`
- ✅ And all other translation files...
- ❌ `ModuleJapaneseLanguagePack.php` (excluded)

## Local Development

Translation sync only runs during GitHub Actions builds. For local development:

1. **Option A**: Manually copy updated files from Core when needed
   ```bash
   cp /path/to/mikopbx/Core/src/Common/Messages/ja/*.php Messages/ja/
   ```

2. **Option B**: Let GitHub Actions handle it
   - Make your changes to code or sounds
   - Push to develop/master
   - GitHub Actions will sync translations automatically

## Disabling Translation Sync

To disable automatic translation sync, set `enabled` to `false`:

```json
{
  "translation_sync": {
    "enabled": false,
    ...
  }
}
```

## Using This in Other Language Packs

To add translation sync to another Language Pack module:

1. Add `translation_sync` section to `module.json`
2. Ensure your Language Pack uses the standard workflow from `mikopbx/.github-workflows`
3. Adjust `language_code` to match your language (e.g., "ru", "de", "fr")
4. List any module-specific translation files in `exclude_files`

## Benefits

- 📦 **Always Fresh**: Every release contains latest translations
- 🤖 **Automated**: No manual copying needed
- 🔄 **Weblate Integration**: Changes from translators are automatically included
- 🛡️ **Safe**: Module-specific files are preserved
- ⚡ **Fast**: Only runs during CI/CD, no impact on local development
