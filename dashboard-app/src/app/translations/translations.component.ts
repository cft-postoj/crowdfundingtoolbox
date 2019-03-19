import {Component, OnInit, OnDestroy} from '@angular/core';
import {LanguageService, TranslationsService} from "../_services";
import {Language, Translations} from "../_models";

@Component({templateUrl: 'translations.component.html', styleUrls: ['./translations.component.scss']})
export class TranslationsComponent {
    public languages: Language[] = [];
    public translations: Translations[] = [];
    public allTranslations: Translations[] = [];

    constructor(
        private languageService: LanguageService,
        private translationService: TranslationsService
    ) {
    }

    ngOnInit() {
        this.loadAllLanguages();
    }

    public setLanguage(id) {
        this.loadTermsById(id);
    }

    public searching(string) {
        let searchingTranslations = this.translations;
        this.translations = [];
        if (string == '') {
            this.translations = this.allTranslations;
        }
        searchingTranslations.forEach((trans, key) => {
            if (trans.trans_id.indexOf(string) > -1) {
                this.translations.push(trans);
            }
        });
    }

    private loadAllLanguages() {
        this.languageService.getAll().subscribe((languages: Language[]) => {
            this.languages = languages;
        });
    }

    private loadTermsById(currentId) {
        this.translationService.getTranslationsById(currentId).subscribe((translations: Translations[]) => {
            this.translations = translations;
            this.allTranslations = translations;
        });
    }
}
