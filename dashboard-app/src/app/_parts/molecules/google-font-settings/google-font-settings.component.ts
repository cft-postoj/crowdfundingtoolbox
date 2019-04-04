import {Component, Input, OnChanges, OnInit, ViewChild, ElementRef} from '@angular/core';
import {DropdownItem} from "../../../_models/dropdown-item";
import {GoogleFontsService} from "../../../_services/google-fonts.service";
import {delay} from "q";


@Component({
    selector: 'app-google-font-settings',
    templateUrl: './google-font-settings.component.html',
    styleUrls: ['./google-font-settings.component.scss']
})
export class GoogleFontSettingsComponent implements OnInit {

    @ViewChild('fontFamilyList') fontFamilyRef: any;

    public numberOptions: DropdownItem[] = [];
    public fontFamily: any = [];
    private numberGoogleFonts: number = 10;
    public fontFamilyStrings: string[] = [];
    public currentFonts: string = '';
    public selectedValues: string[] = [];
    public currentOptionValue: string = '';

    constructor(private googleFontsService: GoogleFontsService) {
    }

    ngOnInit() {
        this.initNumberOptions();
        this.selectedValues = ['Open Sans', 'Lato'];
        this.fetchGoogleFonts();
    }

    private fetchGoogleFonts() {
        this.fontFamilyStrings = [];
        this.fontFamily = [];
        this.currentFonts = '';
        this.googleFontsService.getFonts().pipe().subscribe(
            data => {
                if (data.items.length > 0) {
                    data.items.map((d, key) => {
                        if (key < this.numberGoogleFonts) {
                            this.fontFamily.push({id: d.family, value: d.family});
                            this.fontFamilyStrings.push(d.family);
                            this.currentFonts += (this.currentFonts == '') ? d.family : '|' + d.family;
                        }
                    })
                }
            }
        );

    }

    private initNumberOptions() {
        this.numberOptions = [
            {
                title: '5 fonts',
                value: 5
            },
            {
                title: '10 fonts',
                value: 10
            },
            {
                title: '20 fonts',
                value: 20
            },
            {
                title: '30 fonts',
                value: 30
            },
            {
                title: '50 fonts',
                value: 50
            },
            {
                title: '100 fonts',
                value: 100
            },
            {
                title: 'all fonts',
                value: 0
            }

        ];
        this.currentOptionValue = this.numberOptions[1].value;
    }


    public countOfFonts(e) {
        this.numberGoogleFonts = e;
        this.fetchGoogleFonts();
    }


    public openAction() {
        let children = this.fontFamilyRef.choiceMenuElRef.nativeElement.children;
        for (let ch of children) {
            let currentFontFamily = ch.children[0].children[0].innerText;
            console.log(currentFontFamily);
            ch.style.fontFamily = currentFontFamily;
        }
    }
}
