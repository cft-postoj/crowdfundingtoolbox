import { Component, OnInit, OnDestroy } from '@angular/core';
import {LanguageService} from "../../_services";
import {Language} from "../../_models";

@Component({ templateUrl: 'new-translation.component.html', selector: 'content' })
export class NewTranslationComponent {
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
