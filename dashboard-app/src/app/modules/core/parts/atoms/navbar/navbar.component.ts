import {Component, Input, OnInit} from '@angular/core';
import {NavbarItem} from '../../../models/navbar-item';
import {Router} from '@angular/router';

@Component({
    selector: 'app-navbar',
    templateUrl: './navbar.component.html',
    styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {

    @Input()
    navItems: NavbarItem[];

    constructor(private router: Router) {
    }

    ngOnInit() {
        this.checkUrl();
    }

    showPage(index) {
        return this.router.navigateByUrl(this.navItems[index].url);
    }

    private checkUrl() {
        this.navItems.map((item, key) => {
            item.active = false;
            if (this.router.isActive(item.url, false)) {
                item.active = true;
            }

        });
    }

}
