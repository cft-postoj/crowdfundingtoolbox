import {Component, EventEmitter, OnInit, Output} from '@angular/core';

@Component({
    selector: 'app-upload-csv',
    templateUrl: './upload-csv.component.html',
    styleUrls: ['./upload-csv.component.scss']
})
export class UploadCsvComponent implements OnInit {

    @Output()
    public changeFileEmitter = new EventEmitter();

    constructor() {
    }

    ngOnInit() {
    }

    public changeUploadListener(files: FileList) {
        this.changeFileEmitter.emit(files);
    }

}
