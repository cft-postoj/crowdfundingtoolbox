import { Component, OnInit, OnDestroy } from '@angular/core';
import {LanguageService} from "../../services/language.service";
import {Language} from "../../models/language";

@Component({ templateUrl: 'translation-create.component.html', selector: 'content' })
export class TranslationCreateComponent {
    public languages: Language[] = [];
    constructor(private languageService: LanguageService) {}

    ngOnInit() {
        this.loadAllLanguages();
    }

    private loadAllLanguages() {
        this.languageService.getAll().subscribe((languages: Language[]) => {
            this.languages = languages;
        });
    }
}
