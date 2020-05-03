import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {devices, RadioButton} from '../../modules/core/models';

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

    @Input()
    public saveWithoutClosingButton: any;

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
            this.deviceTypeButtons.push(new RadioButton(devices.desktop.name, devices.desktop.name,
                '/assets/images/icons/desktop_default.svg'));
            this.deviceTypeButtons.push(new RadioButton(devices.tablet.name, devices.tablet.name,
                '/assets/images/icons/tablet_default.svg'));
            this.deviceTypeButtons.push(new RadioButton(devices.mobile.name, devices.mobile.name,
                '/assets/images/icons/mobile_default.svg'));
        }
    }

    public showPreview() {
        this.preview.emit();
    }

    public discardChanges() {

    }

    public submitChanges(close = false) {
        this.submit.emit(close);
    }

    handleDeviceTypeChange(event) {
        this.deviceTypeChange.emit(event);
    }

}
