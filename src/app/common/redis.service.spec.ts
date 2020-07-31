import { TestBed } from '@angular/core/testing';

import { RedisService } from './redis.service';
import { ElectronService } from './electron.service';

describe('RedisService', () => {
  let service: RedisService;
  const id = 'test';

  beforeEach(() => {
    if (!service) {
      TestBed.configureTestingModule({
        providers: [
          ElectronService,
          RedisService
        ]
      });
      service = TestBed.inject(RedisService);
      service.create(id, {
        host: 'dell'
      });
    }
  });

  it('get databases config', () => {
    const result = service.config(id, 'databases');
    expect(result).not.toBeNull();
    expect(result.error).toBe(0);
  });

  it('select database', () => {
    const result = service.select(id, 1);
    expect(result).not.toBeNull();
    expect(result.error).toBe(0);
  });

  it('scan keys', () => {
    const result = service.scan(id);
    expect(result).not.toBeNull();
    expect(result.error).toBe(0);
  });
});
