import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Routing } from '../../constants/config.constants';

@Component({
    selector: 'app-general-settings',
    templateUrl: './general-settings.component.html',
    styleUrls: ['./general-settings.component.scss', '../settings/settings.component.scss']
})
export class GeneralSettingsComponent implements OnInit {

    public opened: number;

    public loading = false;

    public colors = ['#9E0B0F', '#114B7D', '#FF7C12', '#598527', '#754C24', '#000',
        '#ED1C24', '#0087ED', '#F7AF00', '#8DC63F', '#fff', '#555555'];
    public newColor = '#9E0B0F';

    constructor(private router: Router) { }

    ngOnInit() {
    }

    public isOpened(tabNumber: number) {
        return this.opened === tabNumber;
    }

    public openTab(tabNumber: number) {
        this.opened = this.opened === tabNumber ? 0 : tabNumber;
    }

    public delete(deleteIndex: number) {
        this.colors = this.colors.slice(0, deleteIndex).concat(this.colors.slice(deleteIndex + 1, this.colors.length));
    }

    addColor() {
        this.colors.push('#fff');
    }

    changeValueInArray(index, color) {
        this.colors[index] = color;
    }

    closeEditWindow() {
        const targetUrl = this.router.url.split('/(' + Routing.RIGHT_OUTLET)[0];
        this.router.navigateByUrl(targetUrl);
    }

}
