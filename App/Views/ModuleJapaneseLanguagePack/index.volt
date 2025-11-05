<div class="ui segment">
    <h2 class="ui header">
        <i class="japan flag"></i>
        <div class="content">
            {{ t._('BreadcrumbModuleJapaneseLanguagePack') }}
            <div class="sub header">{{ t._('SubHeaderModuleJapaneseLanguagePack') }}</div>
        </div>
    </h2>

    <div class="ui two statistics">
        <div class="statistic">
            <div class="value">
                <i class="microphone icon"></i> {{ soundFileCount }}
            </div>
            <div class="label">{{ t._('mlp_SoundFiles') }}</div>
        </div>
        <div class="statistic">
            <div class="value">
                <i class="language icon"></i> {{ translationFileCount }}
            </div>
            <div class="label">{{ t._('mlp_Translations') }}</div>
        </div>
    </div>

    <div class="ui info message">
        <p>{{ t._('mlp_Step1') }}</p>
    </div>

    <a href="{{ url('general-settings/modify') }}" class="ui primary button">
        <i class="cog icon"></i>
        {{ t._('mlp_GoToGeneralSettings') }}
    </a>
</div>
