import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {ExportCsvService} from '../../services/export-csv.service';
import { saveAs } from 'file-saver/dist/FileSaver';

@Component({
    selector: 'app-export-csv',
    templateUrl: './export-csv.component.html',
    styleUrls: ['./export-csv.component.scss']
})
export class ExportCsvComponent implements OnInit {

    @Input()
    public title: string;
    @Input()
    public data: any = [];
    @Input()
    public columnNames: any = {};
    @Input()
    public floatButton: string = '';
    @Input()
    public exportType: string = '';
    @Input()
    public exportFrom;
    @Input()
    public exportTo;
    @Input()
    public helperText;
    @Input()
    public fileName: string = '';
    @Output()
    public resultEmitter = new EventEmitter();
    @Output()
    public loadingEmitter = new EventEmitter();

    constructor(private exportCsvService: ExportCsvService) {
    }

    ngOnInit() {
    }

    public export() {
        this.loadingEmitter.emit(true);
        let emitData = {};
        // if (this.data[0].length !== this.columnNames.length) {
        //     emitData = {
        //         alertType: 'danger',
        //         alertMessage: 'Incorrectly defined inputs. Count of titles is not same with count of data items.',
        //         alertOpen: true
        //     };
        //     this.loadingEmitter.emit(false);
        //     return this.resultEmitter.emit(emitData);
        // } else {
            this.exportCsvService.makeExport(this.title, this.exportType, this.exportFrom, this.exportTo).subscribe((d) => {
                saveAs(d, this.fileName + '.csv');
                emitData = {
                    alertType: 'success',
                    alertMessage: 'Export was successfully created.',
                    alertOpen: true
                };
            }, (error) => {
                console.log(error);
                emitData = {
                    alertType: 'danger',
                    alertMessage: 'There was an error during export creating. ERROR: ' + error,
                    alertOpen: true
                };
                this.loadingEmitter.emit(false);
                this.resultEmitter.emit(emitData);
            }, () => {
                this.loadingEmitter.emit(false);
                this.resultEmitter.emit(emitData);
            });
        }
    // }

}
