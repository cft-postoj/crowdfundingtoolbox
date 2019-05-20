import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {environment} from "environments/environment";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class ImageUploadService {

  constructor(private http: HttpClient) { }

  public upload(formData: FormData): Observable<any> {
      return this.http.post(environment.backOfficeUrl + environment.imageUploadUrl, formData);
  }
}
