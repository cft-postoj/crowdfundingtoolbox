import {Component, OnInit} from '@angular/core';
import {Location} from '@angular/common';

@Component({
    selector: 'app-previous-page',
    templateUrl: './previous-page.component.html',
    styleUrls: ['./previous-page.component.scss']
})
export class PreviousPageComponent implements OnInit {

    constructor(private location: Location) {
    }

    ngOnInit() {
    }

    backToPreviousPage() {
        this.location.back();
    }

}
