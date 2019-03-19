import { TestBed } from '@angular/core/testing';

import { ComponentCommunicationService } from './component-communication.service';

describe('ComponentCommunicationService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ComponentCommunicationService = TestBed.get(ComponentCommunicationService);
    expect(service).toBeTruthy();
  });
});
