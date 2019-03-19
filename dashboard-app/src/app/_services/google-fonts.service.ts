import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {environment} from "../../environments/environment";

@Injectable({
  providedIn: 'root'
})
export class GoogleFontsService {

    constructor(private http: HttpClient) {
    }

    public getFonts(): Observable<any> {
      return this.http.get(environment.fontsUrl + '&sort=popularity');
    }
}
