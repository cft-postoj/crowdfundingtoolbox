import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {RadioButton} from "../_parts/atoms/radio-button/radio-button";
import {devices} from '../_models/enums'

@Component({
    selector: 'app-actions',
    templateUrl: './actions.component.html',
    styleUrls: ['./actions.component.scss']
})
export class ActionsComponent implements OnInit {

    @Input()
    deviceType;

    @Input()
    public deviceTypeDefault;

    @Input()
    public submitting: boolean = false;

    @Input()
    public hidePreviewButton;

    @Input()
    public live;

    @Output()
    public deviceTypeChange = new EventEmitter<any>();

    @Output()
    public submit = new EventEmitter<any>();

    @Output()
    public preview = new EventEmitter<any>();

    public deviceTypeButtons: RadioButton[] = [];

    constructor() {
    }

    ngOnInit() {
        if (this.deviceType) {
            this.deviceTypeButtons.push(new RadioButton(devices.desktop.name, devices.desktop.name, "/assets/images/icons/desktop_default.svg"))
            this.deviceTypeButtons.push(new RadioButton(devices.tablet.name, devices.tablet.name, "/assets/images/icons/tablet_default.svg"))
            this.deviceTypeButtons.push(new RadioButton(devices.mobile.name, devices.mobile.name, "/assets/images/icons/mobile_default.svg"))
        }
    }

    public showPreview() {
        this.preview.emit()
    }

    public discardChanges() {

    }

    public submitChanges() {
        this.submit.emit();

    }

    handleDeviceTypeChange(event) {
        this.deviceTypeChange.emit(event)
    }

}
