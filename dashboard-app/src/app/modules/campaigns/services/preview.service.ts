import { Injectable, Output, EventEmitter } from '@angular/core';
import {BehaviorSubject, Subject} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class PreviewService {

    isOpen = false;

    @Output() change: EventEmitter<boolean> = new EventEmitter();

    @Output() htmls= new EventEmitter();

    @Output() updatePreviewChange = new BehaviorSubject(true);

    toggle(value) {
        this.isOpen = value;
        this.change.emit(this.isOpen);
    }

    sendGeneratedHtml(campaignWithHtmls){
        this.htmls.emit(campaignWithHtmls);
    }

    updatePreview() {
        this.updatePreviewChange.next(true)
    }
}
