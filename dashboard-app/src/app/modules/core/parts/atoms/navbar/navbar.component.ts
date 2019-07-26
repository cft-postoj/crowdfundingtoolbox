import {Component, Input, OnInit} from '@angular/core';
import {NavbarItem} from '../../../models/navbar-item';
import {NavigationEnd, NavigationStart, Router} from '@angular/router';
import {Location} from '@angular/common';
import 'rxjs/add/operator/pairwise';
import 'rxjs/add/operator/filter';

@Component({
    selector: 'app-navbar',
    templateUrl: './navbar.component.html',
    styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {

    @Input()
    navItems: NavbarItem[];

    private previousUrl: string;


    constructor(private router: Router, private location: Location) {
        router.events
            .filter(e => e instanceof NavigationEnd)
            .pairwise().subscribe((e: any) => {
            console.log(e);
            localStorage.setItem('previousRoute', e[0].urlAfterRedirects);
        });
    }

    ngOnInit() {
        this.checkUrl();
    }

    showPage(index) {
        setTimeout(() => {
            this.router.navigateByUrl(localStorage.getItem('previousRoute'), {skipLocationChange: false}).then(() =>
                this.router.navigate([this.navItems[index].url]));
        }, 100);

    }

    private checkUrl() {
        this.navItems.map((item, key) => {
            item.active = false;
            if (this.router.isActive(item.url, false)) {
                item.active = true;
            }

        });
    }

    private setActive(setActiveItem) {
        this.navItems.forEach((item, key) => {
            item.active = false;
        });
        setActiveItem.active = true;
    }

}
