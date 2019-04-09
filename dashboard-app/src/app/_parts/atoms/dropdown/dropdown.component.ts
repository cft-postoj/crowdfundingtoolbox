import {Component, EventEmitter, Input, Output} from "@angular/core";
import {DropdownItem} from "../../../_models/dropdown-item";
import {GoogleFontsService} from "../../../_services/google-fonts.service";

@Component({
    selector: 'app-dropdown',
    templateUrl: './dropdown.component.html',
    styleUrls: ['./dropdown.component.scss']
})

export class DropdownComponent {

    @Input() name: string;
    @Input() class: string;
    @Input() items: DropdownItem[];
    @Input() title: string;

    //set true if you want to change font of each option. Font family for option is value of dropdownItem
    @Input() customFonts:boolean = false;

    @Input() currentValue;
    @Output() currentValueChange = new EventEmitter<any>();

    active: boolean;
    selectedItem = new DropdownItem("default", null);
    defaultDropdown = new DropdownItem("default", null);
    private currentFonts: number | "IPv4" | "IPv6" | string;

    constructor(private googleFontsService: GoogleFontsService) {
        this.active = false;
    }

    ngOnInit() {
        if (this.items) {
            this.items.forEach(item => {
                if (item.value == this.currentValue) {
                    this.selectedItem = item;
                }
            })
        }
        if (this.customFonts) {
            this.items.map((item:DropdownItem) => {
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
