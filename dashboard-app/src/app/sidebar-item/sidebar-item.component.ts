import {Component, Input, OnInit} from '@angular/core';
import {DropdownItem} from "../_models/dropdown-item";
import {Routing} from "../constants/config.constants";
import {Router} from "@angular/router";

@Component({
    selector: 'app-sidebar-item',
    templateUrl: './sidebar-item.component.html',
    styleUrls: ['./sidebar-item.component.scss']
})
export class SidebarItemComponent implements OnInit {

    @Input()
    public items: DropdownItem[];
    public routing = Routing;

    constructor( public router: Router) {
    }

    ngOnInit() {
    }

}
