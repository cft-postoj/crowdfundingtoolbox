import {Component, EventEmitter, Input, Output} from '@angular/core';
import {ImageUploadService} from "../../../services/image-upload.service";

@Component({
    selector: 'app-dragAndDrop',
    templateUrl: './dragAndDrop.component.html',
    styleUrls: ['./dragAndDrop.component.scss']
})
export class DragAndDropComponent {
    public file: File;
    public dragOver: boolean;
    public alertOpen: boolean = false;
    public alertMessage: string = '';
    public loading: boolean = false;

    @Input()
    fileUrl: string;

    @Input()
    fileData: any;

    @Input()
    clazz: string;

    @Output()
    fileUrlChange = new EventEmitter<string>();

    @Output()
    fileDataChange = new EventEmitter<any>();

    constructor(private imageUploadService: ImageUploadService) {
        this.dragOver = false;
    }


    ngOnInit() {

    }

    onFileChange(event) {
        this.file = event.target.files[0];
        this.loading = true;
        this.uploadImage(this.file);
    }

    onDropImage() {
        setTimeout(() => {
            this.dragOver = false
        }, 500)
    }

    private uploadImage(file) {
        let formData: FormData = new FormData();
        formData.append('image', file, file.name);
        this.imageUploadService.upload(formData).subscribe(
            data => {
                let fileUrlTemp = data.file.url;
                let myReader: FileReader = new FileReader();
                myReader.onloadend = () => {
                    fileUrlTemp = myReader.result;
                };
                myReader.readAsDataURL(this.file);
                this.loading = false;
                this.fileData = data.file;
                this.fileDataChange.emit(this.fileData);
                this.fileUrl = this.fileData.url
            },

            e => {
                this.alertOpen = true;
                this.alertMessage = e.error.error.image[0];
                this.loading = false;
                window.localStorage.removeItem('campaignImage');
            }
        )
    }

    getUrl() {
        return this.fileUrl;
    }
}
