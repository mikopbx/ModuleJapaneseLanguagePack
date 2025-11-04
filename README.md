# Japanese Language Pack for MikoPBX

[![MikoPBX](https://img.shields.io/badge/MikoPBX-2025.1.1+-blue.svg)](https://github.com/mikopbx/Core)
[![License](https://img.shields.io/badge/License-GPLv3-green.svg)](LICENSE)
[![Module Type](https://img.shields.io/badge/Module%20Type-Language%20Pack-orange.svg)]()

Complete Japanese language support module for MikoPBX including UI translations and voice prompts.

## 📦 Package Contents

- **15 Translation Files** (`Messages/ja/`)
  - Complete Japanese UI translations for all system components
  - Multi-file translation structure for better organization

- **612 Sound Files** (`Sounds/ja-jp/`)
  - Professional Japanese voice prompts
  - Full coverage of system messages, digits, letters, and phonetic alphabet

## 🎯 Module Type

This is a **Language Pack** module (`module_type: "languagepack"`).

Language Pack modules have special behavior:
- ✅ Sound files installed **WITHOUT prefix** (replace/extend system sounds)
- ✅ Only **ONE Language Pack per language** allowed (conflict prevention)
- ✅ Automatic installation and removal
- ✅ No additional configuration required

## 📋 Requirements

- **MikoPBX**: 2025.1.1 or higher
- **Language Code**: `ja-jp` (Japanese)

## 🚀 Installation Methods

### 1. MikoPBX Marketplace (Recommended)

1. Open MikoPBX admin interface
2. Navigate to **System** → **Extension Modules** → **Marketplace**
3. Search for "Japanese Language Pack"
4. Click **Install** and then **Enable**

### 2. ZIP Archive Upload

1. Download the latest release ZIP from [GitHub Releases](https://github.com/mikopbx/ModuleJapaneseLanguagePack/releases)
2. Open MikoPBX admin interface
3. Navigate to **System** → **Extension Modules**
4. Click **Upload Module**
5. Select the downloaded ZIP file
6. Click **Install** and then **Enable**

**ZIP Structure:**
```
ModuleJapaneseLanguagePack.zip
└── ModuleJapaneseLanguagePack/
    ├── module.json
    ├── ModuleJapaneseLanguagePackConf.php
    ├── Setup/
    ├── Messages/
    ├── Sounds/
    └── ...
```

### 3. GitHub Release (Direct Download)

```bash
# Download latest release
cd /tmp
wget https://github.com/mikopbx/ModuleJapaneseLanguagePack/releases/latest/download/ModuleJapaneseLanguagePack.zip

# Upload through web interface or extract manually
unzip ModuleJapaneseLanguagePack.zip -d /storage/usbdisk1/mikopbx/custom_modules/
chown -R www:www /storage/usbdisk1/mikopbx/custom_modules/ModuleJapaneseLanguagePack
chmod -R 755 /storage/usbdisk1/mikopbx/custom_modules/ModuleJapaneseLanguagePack
```

### 4. Manual Git Clone (Development)

```bash
cd /storage/usbdisk1/mikopbx/custom_modules/
git clone git@github.com:mikopbx/ModuleJapaneseLanguagePack.git
cd ModuleJapaneseLanguagePack
git checkout develop  # or specific version tag
chown -R www:www /storage/usbdisk1/mikopbx/custom_modules/ModuleJapaneseLanguagePack
chmod -R 755 /storage/usbdisk1/mikopbx/custom_modules/ModuleJapaneseLanguagePack
```

## 🔧 How It Works

### Translation System

The module uses **multi-file translation structure** for better organization:

```
Messages/
└── ja/
    ├── Common.php           # Common translations (50 KB)
    ├── Extensions.php       # Extension-related (12 KB)
    ├── GeneralSettings.php  # System settings (48 KB)
    ├── Providers.php        # Providers (33 KB)
    ├── Route.php           # Routes (45 KB)
    ├── MailSettings.php    # Mail settings (18 KB)
    ├── NetworkSecurity.php # Security (12 KB)
    ├── Modules.php         # Modules (8 KB)
    ├── ApiKeys.php         # API keys (7 KB)
    ├── Passwords.php       # Passwords (5 KB)
    ├── StoplightElements.php # UI elements (4 KB)
    ├── AsteriskRestUsers.php # REST users (3 KB)
    ├── Auth.php            # Authentication (minimal)
    ├── Passkeys.php        # Passkeys (minimal)
    └── RestApi.php         # REST API (minimal)
```

**Loading Process:**
1. Core translations loaded from `src/Common/Messages/en/` and `src/Common/Messages/ja/`
2. Module translations loaded from `Messages/ja/*.php`
3. All translation files merged automatically by `MessagesProvider::loadModuleTranslations()`

### Sound Files System

Sound files are automatically managed by `SoundFilesConf::installModuleSounds()`:

```
Sounds/
└── ja-jp/
    ├── hello.gsm
    ├── goodbye.gsm
    ├── vm-intro.gsm
    ├── digits/
    │   ├── 0.gsm
    │   ├── 1.gsm
    │   └── ... (more digits)
    ├── letters/
    │   ├── a.gsm
    │   ├── b.gsm
    │   └── ... (more letters)
    ├── phonetic/
    │   ├── alpha_1.gsm
    │   └── ... (more phonetic)
    └── ... (612 files total)
```

**Installation Location**: `/mountpoint/mikopbx/media/sounds/ja-jp/`

**File Naming**: Language Pack modules install files **without module prefix**:
- ✅ `hello.gsm` → `hello.gsm` (direct replacement)
- ❌ NOT `modulejapaneselanguagepack-hello.gsm`

### Using Japanese in Dialplan

After installation, Japanese becomes available system-wide:

```php
public function extensionGenContexts(): string
{
    return "[japanese-greeting]\n" .
           "exten => *88,1,Answer()\n" .
           "\tsame => n,Set(CHANNEL(language)=ja-jp)\n" .  // Set Japanese language
           "\tsame => n,Playback(hello)\n" .                // Plays Japanese hello.gsm
           "\tsame => n,Playback(digits/5)\n" .             // Plays Japanese "5"
           "\tsame => n,Playback(goodbye)\n" .              // Plays Japanese goodbye.gsm
           "\tsame => n,Hangup()\n\n";
}
```

**UI Language:**
Japanese translations become available in the web interface language selector after module installation.

## 🛡️ Conflict Prevention

The module automatically checks for conflicts during installation:

```php
// Only one Japanese Language Pack allowed per system
$conflict = PbxExtensionUtils::checkLanguagePackConflict(
    'ModuleJapaneseLanguagePack',
    'ja-jp'
);

if ($conflict) {
    // Installation blocked - another Japanese pack exists
    throw new Exception("Conflict with $conflict");
}
```

**Why?** Language Pack modules replace system sounds without prefix. Multiple packs for the same language would overwrite each other's files.

## 📊 Technical Details

### Module Structure

```
ModuleJapaneseLanguagePack/
├── .github/                              # GitHub Actions workflows
├── .gitignore                            # Git ignore rules
├── module.json                           # Module metadata
├── Lib/                                  # Module libraries
│   └── ModuleJapaneseLanguagePackConf.php  # Module configuration class
├── Setup/
│   └── PbxExtensionSetup.php            # Installation logic
├── Messages/
│   └── ja/                              # Translation files (15 files)
│       ├── Common.php
│       ├── Extensions.php
│       └── ...
└── Sounds/
    └── ja-jp/                           # Sound files (612 files)
        ├── *.gsm
        ├── digits/
        ├── letters/
        └── phonetic/
```

### Module Configuration

**module.json:**
```json
{
  "developer": "MIKO",
  "moduleUniqueID": "ModuleJapaneseLanguagePack",
  "support_email": "help@miko.ru",
  "version": "%ModuleVersion%",
  "min_pbx_version": "2025.1.1",
  "module_type": "languagepack",
  "language_code": "ja-jp",
  "release_settings": {
    "publish_release": true,
    "changelog_enabled": true,
    "create_github_release": true
  }
}
```

### Key Classes

- **ModuleJapaneseLanguagePackConf**: Main module configuration
- **PbxExtensionSetup**: Installation/uninstallation handler with conflict checking
- **PbxExtensionUtils**: Language Pack detection and conflict prevention
- **MessagesProvider**: Multi-file translation loading
- **SoundFilesConf**: Sound file installation/removal

## 🔄 Uninstallation

### Through Admin Interface

1. Go to **System** → **Extension Modules**
2. Find "Japanese Language Pack"
3. Click **Disable**
4. Click **Uninstall**

### What Gets Removed

When you uninstall the module:
- ✅ All translation files removed from memory cache
- ✅ Entire `/mountpoint/mikopbx/media/sounds/ja-jp/` directory deleted
- ✅ Module files removed from `/custom_modules/`
- ✅ Database record removed from `m_PbxExtensionModules`

**Note:** After uninstallation, Japanese language will no longer be available in the system.

## 🌍 Creating Your Own Language Pack

Want to create a Language Pack for another language? Use this module as a template!

### Quick Start

1. **Clone the repository:**
   ```bash
   git clone git@github.com:mikopbx/ModuleJapaneseLanguagePack.git ModuleMyLanguagePack
   cd ModuleMyLanguagePack
   ```

2. **Update module.json:**
   ```json
   {
     "moduleUniqueID": "ModuleMyLanguagePack",
     "module_type": "languagepack",
     "language_code": "xx-xx"
   }
   ```

3. **Add your translations:**
   ```
   Messages/xx/Common.php
   Messages/xx/Extensions.php
   ...
   ```

4. **Add your sound files:**
   ```
   Sounds/xx-xx/hello.gsm
   Sounds/xx-xx/goodbye.gsm
   Sounds/xx-xx/digits/0.gsm
   ...
   ```

5. **Update class names:**
   - `ModuleJapaneseLanguagePackConf` → `ModuleMyLanguagePackConf`
   - `ModuleJapaneseLanguagePack` namespace → `ModuleMyLanguagePack`

6. **Test and deploy!**

### Translation File Format

Each translation file should return an associative array:

```php
<?php
// Messages/xx/Common.php
return [
    'ex_Save' => 'Guardar',
    'ex_Cancel' => 'Cancelar',
    'ex_Add' => 'Añadir',
    // ... more translations
];
```

### Sound File Requirements

- **Format**: GSM, WAV, ULAW, ALAW, G722, SLN
- **Recommended**: GSM (compact size, good quality)
- **Sample Rate**: 8000 Hz
- **Channels**: Mono

## 📝 Development

### Building from Source

```bash
# Clone the repository
git clone git@github.com:mikopbx/ModuleJapaneseLanguagePack.git
cd ModuleJapaneseLanguagePack

# Switch to develop branch
git checkout develop

# Build ZIP archive
zip -r ModuleJapaneseLanguagePack.zip . \
  -x "*.git*" \
  -x "*.idea*" \
  -x "*.DS_Store" \
  -x "*node_modules*"
```

### Version Management

Versions are managed through git tags:
```bash
git tag -a v1.0.0 -m "Release version 1.0.0"
git push origin v1.0.0
```

GitHub Actions automatically creates releases from tags.

### Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/my-feature`
3. Commit your changes: `git commit -am 'Add new feature'`
4. Push to the branch: `git push origin feature/my-feature`
5. Submit a Pull Request to `develop` branch

## 📚 Related Documentation

- **MikoPBX Core**: [github.com/mikopbx/Core](https://github.com/mikopbx/Core)
- **Module Development**: See `CLAUDE.md` in MikoPBX Core repository
- **Sound Files Guide**: Module Development Docs → Sound Files Integration
- **Translation System**: Common Providers Documentation

## 🐛 Troubleshooting

### Installation Issues

**Problem**: "Another Japanese Language Pack is already installed"
- **Solution**: Uninstall the existing Japanese pack first, then retry

**Problem**: "Sounds not playing in Japanese"
- **Solution**:
  1. Check if module is enabled: **System** → **Extension Modules**
  2. Verify language code in dialplan: `Set(CHANNEL(language)=ja-jp)`
  3. Check sound files exist: `ls /mountpoint/mikopbx/media/sounds/ja-jp/`

**Problem**: "Translations not showing in UI"
- **Solution**:
  1. Clear browser cache
  2. Log out and log back in
  3. Check language selector in user profile
  4. Verify module is enabled

### Debug Mode

Enable debug logging:
```bash
# Check module installation logs
grep "ModuleJapaneseLanguagePack" /var/log/mikopbx/messages

# Check sound file installation
ls -lah /mountpoint/mikopbx/media/sounds/ja-jp/ | head -20

# Test specific sound file
asterisk -rx "console dial *88@test-context"
```

## 📄 License

GNU General Public License v3.0

See [LICENSE](LICENSE) file for details.

## 👨‍💻 Developer

**MIKO**
- Website: [www.miko.ru](https://www.miko.ru)
- Email: help@miko.ru
- GitHub: [github.com/mikopbx](https://github.com/mikopbx)

## 🙏 Acknowledgments

- Japanese translations provided by professional translators
- Voice prompts recorded by native Japanese speakers
- Built on [MikoPBX](https://github.com/mikopbx/Core) open-source PBX platform

---

**Version**: %ModuleVersion%
**Language**: Japanese (ja-jp)
**Module Type**: Language Pack
**Files**: 15 translations + 612 sounds
**Repository**: [github.com/mikopbx/ModuleJapaneseLanguagePack](https://github.com/mikopbx/ModuleJapaneseLanguagePack)
