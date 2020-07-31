import { TestBed } from '@angular/core/testing';

import { ElectronService } from './electron.service';

describe('ElectronService', () => {
  let service: ElectronService;

  beforeEach(() => {
    if (!service) {
      TestBed.configureTestingModule({
        providers: [
          ElectronService
        ]
      });
      service = TestBed.inject(ElectronService);
    }
  });

  it('is electron', () => {
    expect(service.isElectron).toBeTruthy();
  });

  it('test remote', () => {
    expect(service.remote.app).not.toBeNull();
  });
});
