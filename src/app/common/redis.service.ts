import { Injectable } from '@angular/core';
import { ElectronService } from './electron.service';
import * as IORedis from 'ioredis';

@Injectable({
  providedIn: 'root'
})
export class RedisService {
  constructor(
    private electron: ElectronService
  ) {
  }

  create(id: string, options: IORedis.RedisOptions): void {
    this.electron.ipcRenderer.send('redis:create', {
      id,
      options
    });
  }

  scan(id: string): any {
    return this.electron.ipcRenderer.sendSync('redis:scan', {
      id
    });
  }

  destory(id: string): void {
    this.electron.ipcRenderer.send('redis:destory', {
      id
    });
  }
}
