import {Component, Input, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {DropdownItem, sidebarType} from '../../models';
import {Routing} from '../../../../constants/config.constants';

@Component({
    selector: 'app-sidebar-item',
    templateUrl: './sidebar-item.component.html',
    styleUrls: ['./sidebar-item.component.scss']
})
export class SidebarItemComponent implements OnInit {

    @Input()
    public items: DropdownItem[];

    @Input()
    public currentType;
    public sidebarTypes = sidebarType;
    public routing = Routing;

    constructor( public router: Router) {
    }

    ngOnInit() {
        console.log(sidebarType)
    }

}
