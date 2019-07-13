import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../../../environments/environment';

@Injectable({
    providedIn: 'root'
})
export class ExportCsvService {

    constructor(private http: HttpClient) {
    }

    public makeExport(title: string, data: any, columnNames: any) {
        return this.http.post(`${environment.backOfficeUrl}${environment.exportCsv}`, {
            title: title,
            data: data,
            columnNames: columnNames
        });
    }
}
