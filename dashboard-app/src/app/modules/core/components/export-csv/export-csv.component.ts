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
        if (this.data[0].length !== this.columnNames.length) {
            emitData = {
                alertType: 'danger',
                alertMessage: 'Incorrectly defined inputs. Count of titles is not same with count of data items.',
                alertOpen: true
            };
            return this.resultEmitter.emit(emitData);
        } else {
            this.exportCsvService.makeExport(this.title, this.data, this.columnNames, this.exportType).subscribe((d) => {
                // this.fileSaver.msSaveOrOpenBlob(d, 'donors-export.csv');
                saveAs(d, 'donors-export.csv');
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
            }, () => {
                return this.resultEmitter.emit(emitData);
            });
        }
    }

}
