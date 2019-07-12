import {Component, ElementRef, EventEmitter, Input, OnInit, Output, ViewChild} from '@angular/core';

@Component({
    selector: 'app-upload-csv',
    templateUrl: './upload-csv.component.html',
    styleUrls: ['./upload-csv.component.scss']
})
export class UploadCsvComponent implements OnInit {

    @Output()
    public changeFileEmitter = new EventEmitter();
    @Input()
    public loading: boolean;

    @ViewChild('fileUploading')
    fileInput: ElementRef;


    constructor() {
    }

    ngOnInit() {
    }

    public changeUploadListener(files: FileList) {
        this.changeFileEmitter.emit(files[0]);
    }

    public showFileUpload() {
        this.fileInput.nativeElement.value = '';
        this.fileInput.nativeElement.click();
    }

}
