<div class="ui segment">
    <div class="ui message">
        <div class="header">
            <i class="japan flag"></i>
            {{ t._('BreadcrumbModuleJapaneseLanguagePack') }}
        </div>
        <p>{{ t._('SubHeaderModuleJapaneseLanguagePack') }}</p>
    </div>

    <div class="ui three column stackable grid">
        <div class="column">
            <div class="ui segment">
                <h3 class="ui header">
                    <i class="microphone icon"></i>
                    <div class="content">
                        {{ t._('mlp_SoundFiles') }}
                        <div class="sub header">{{ t._('mlp_SoundFilesDescription') }}</div>
                    </div>
                </h3>
                <div class="ui statistic">
                    <div class="value">
                        {{ soundFileCount }}
                    </div>
                    <div class="label">{{ t._('mlp_Files') }}</div>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="ui segment">
                <h3 class="ui header">
                    <i class="language icon"></i>
                    <div class="content">
                        {{ t._('mlp_Translations') }}
                        <div class="sub header">{{ t._('mlp_TranslationsDescription') }}</div>
                    </div>
                </h3>
                <div class="ui statistic">
                    <div class="value">
                        {{ translationFileCount }}
                    </div>
                    <div class="label">{{ t._('mlp_TranslationFiles') }}</div>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="ui segment">
                <h3 class="ui header">
                    <i class="checkmark icon"></i>
                    <div class="content">
                        {{ t._('mlp_HowToUse') }}
                        <div class="sub header">{{ t._('mlp_HowToUseDescription') }}</div>
                    </div>
                </h3>
                <div class="ui list">
                    <div class="item">
                        <i class="right triangle icon"></i>
                        <div class="content">
                            {{ t._('mlp_Step1') }}
                        </div>
                    </div>
                    <div class="item">
                        <i class="right triangle icon"></i>
                        <div class="content">
                            {{ t._('mlp_Step2') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ui info message">
        <div class="header">
            <i class="info circle icon"></i>
            {{ t._('mlp_ImportantNote') }}
        </div>
        <p>{{ t._('mlp_ImportantNoteText') }}</p>
    </div>

    <div class="ui segment">
        <h3 class="ui header">
            <i class="book icon"></i>
            {{ t._('mlp_WhatsIncluded') }}
        </h3>
        <div class="ui list">
            <div class="item">
                <i class="check circle outline icon green"></i>
                <div class="content">
                    <div class="header">{{ t._('mlp_VoicePrompts') }}</div>
                    <div class="description">{{ t._('mlp_VoicePromptsText') }}</div>
                </div>
            </div>
            <div class="item">
                <i class="check circle outline icon green"></i>
                <div class="content">
                    <div class="header">{{ t._('mlp_UITranslations') }}</div>
                    <div class="description">{{ t._('mlp_UITranslationsText') }}</div>
                </div>
            </div>
            <div class="item">
                <i class="check circle outline icon green"></i>
                <div class="content">
                    <div class="header">{{ t._('mlp_AutomaticIntegration') }}</div>
                    <div class="description">{{ t._('mlp_AutomaticIntegrationText') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="ui buttons">
        <a href="{{ url('general-settings/modify') }}" class="ui blue button">
            <i class="cog icon"></i>
            {{ t._('mlp_GoToGeneralSettings') }}
        </a>
        <a href="https://github.com/mikopbx/ModuleJapaneseLanguagePack" target="_blank" class="ui button">
            <i class="github icon"></i>
            {{ t._('mlp_ViewOnGitHub') }}
        </a>
    </div>
</div>
