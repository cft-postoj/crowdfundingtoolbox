import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {ExportCsvService} from '../../services/export-csv.service';

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
    @Output()
    public resultEmitter = new EventEmitter();

    constructor(private exportCsvService: ExportCsvService) {
    }

    ngOnInit() {
    }

    public export() {
        let emitData = {};
        if (this.data[0].length !== this.columnNames.length) {
            emitData = {
                alertType: 'danger',
                alertMessage: 'Incorrectly defined inputs. Count of titles is not same with count of data items.',
                alertOpen: true
            };
            return this.resultEmitter.emit(emitData);
        } else {
            this.exportCsvService.makeExport(this.title, this.data, this.columnNames).subscribe((d) => {
                console.log(d);
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
