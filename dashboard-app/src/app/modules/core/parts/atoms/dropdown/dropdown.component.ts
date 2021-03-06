import {Component, EventEmitter, Input, OnChanges, OnInit, Output} from "@angular/core";
import {DropdownItem} from "../../../models/dropdown-item";
import {GoogleFontsService} from "../../../services/google-fonts.service";


@Component({
    selector: 'app-dropdown',
    templateUrl: './dropdown.component.html',
    styleUrls: ['./dropdown.component.scss']
})

export class DropdownComponent implements OnInit, OnChanges{

    @Input() name: string;
    @Input() class: string;
    @Input() clazz: string;
    @Input() items: DropdownItem[];
    @Input() title: string;

    // set true if you want to change font of each option. Font family for option is value of dropdownItem
    @Input() customFonts: boolean = false;

    @Input() currentValue;
    @Output() currentValueChange = new EventEmitter<any>();

    active: boolean;
    selectedItem = new DropdownItem("default", null);
    defaultDropdown = new DropdownItem("default", null);
    public currentFonts: number | "IPv4" | "IPv6" | string;

    constructor(private googleFontsService: GoogleFontsService) {
        this.active = false;
    }

    ngOnInit() {
        this.setUp();
    }

    ngOnChanges(){
        this.setUp();
    }

    private setUp() {
        if (this.items) {
            this.items.forEach(item => {
                if (item.value == this.currentValue) {
                    this.selectedItem = item;
                }
            })
        }
        if (this.customFonts) {
            this.items.forEach((item: DropdownItem) => {
                this.currentFonts += (this.currentFonts == '') ? item.value : '|' + item.value;
            })
        }
    }

    onButtonClick(event) {
        this.currentValueChange.emit(this.selectedItem.value);
    }

    byTitle(item1: DropdownItem, item2: DropdownItem) {
        return item1 && item2 ? item1.title === item2.title : item1 === item2;
    }

}
