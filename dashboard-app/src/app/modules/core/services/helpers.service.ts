import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class HelpersService {

  constructor() { }

  public writeDateAsString(date: any): string {
    return `${date.year}-${date.month}-${date.day}`;
  }
}
