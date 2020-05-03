import {EventEmitter, Input, Output} from '@angular/core';
import {Widget} from '../../models';
import {environment} from '../../../../../environments/environment';
import {
    devices,
    widgetTypes
} from '../../../core/models';

export class WidgetEditBase {

    @Input() widget;
    @Input() open: boolean = false;
    @Input() deviceType = devices.desktop.name;
    @Input() fontFamilyDropdownButtons;
    @Input() colors;
    @Input() title;

    @Output() openChange: EventEmitter<boolean> = new EventEmitter();


    uploadUrl: string = environment.backOfficeUrl + '/upload-wysiwyg';
    widgetTypes = widgetTypes;
    assetsUrl: string;


    constructor() {
        this.assetsUrl = (environment.production) ? 'assets/' : '../../../../assets/';
    }


    public toogleOpen() {
        this.open = !this.open;
        this.openChange.emit(this.open);
    }
}
